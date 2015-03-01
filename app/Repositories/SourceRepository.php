<?php

namespace App\Repositories;
use App\Course;
use App\CourseLesson;
use App\Helpers\MarkdownHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class SourceRepository {

    private $client;
    private $markdown;

    function __construct()
    {
        $this->markdown = new MarkdownHelper();
        $this->client = new Client();
        $oauth = new Oauth1([
            'consumer_key'    => config('services.bitbucket.client_id'),
            'consumer_secret' => config('services.bitbucket.client_secret')
        ]);
        $this->client->getEmitter()->attach($oauth);
    }

    public function get()
    {
        $only_existing_courses = [];
        $only_existing_lessons = [];
        foreach ($this->getRepositoriesList() as $repo) {
            if(substr($repo['name'], 0, 7) != 'Kurs - ')
                continue;

            $branches = $this->getBranches($repo['full_name']);
            foreach ($branches as $branch_name => $branch) {
                if(substr($branch_name, 0, 1) != 'v' && $branch_name != 'develop')
                    continue;
                $slug = explode('/', $repo['full_name'], 2);
                $slug = $slug[1];
//                $slug = $repo['full_name'];

                try{
                    $Course = Course::whereSlug($slug)->whereVersion($branch_name)->withTrashed()->firstOrFail();
                    $Course->restore();
                }catch (\Exception $e){
                    $Course = new Course();
                    $Course->slug = $slug;
                    $Course->version = $branch_name;
                }
                $Course->name = $repo['name'];
                $Course->save();
                $only_existing_courses[] = $Course->id;



                $lessons = $this->download($repo['full_name'], $branch_name);

                foreach($lessons['course'] as $s=>$lesson){
                    try{
                        $l = CourseLesson::whereSlug($s)->whereCourseId($Course->id)->withTrashed()->firstOrFail();
                        $l->restore();
                    }catch (\Exception $e){
                        $l = new CourseLesson();
                        $l->slug = $s;
                        $l->course_id = $Course->id;
                    }
                    $prased = $this->markdown->parseMeta($lesson);
                    $l->name = isset($prased[1]['title'][0]) ? $prased[1]['title'][0] : null;
                    $l->need_login = isset($prased[1]['private'][0]) && strtolower($prased[1]['private'][0]) == true ? true : false;
                    $l->content = $lesson;
                    $l->authors = isset($prased[1]['author']) ? $prased[1]['author'] : [];
                    $l->reviewers = isset($prased[1]['reviewer']) ? $prased[1]['reviewer'] : [];
                    $l->updates = isset($prased[1]['date']) ? $prased[1]['date'] : [];

                    $l->sources = [];
                    if(isset($prased[1]['source'])){
                        foreach ($prased[1]['source'] as $key=>$val) {
                            if(is_numeric($key)){
                                $l->sources[$val] = null;
                            }else{
                                $l->sources[$key] = $val;
                            }
                        }
                    }

                    try{
                        $l->last_update = isset($prased[1]['date']) ? new \Carbon\Carbon(end($prased[1]['date'])) : null;
                    }catch(\Exception $e){
                        $l->last_update = null;
                    }

                    $l->save();
                    $only_existing_lessons[] = $l->id;
                }

            }
        }


        CourseLesson::whereNotIn('id', $only_existing_lessons)->delete();
        Course::whereNotIn('id', $only_existing_courses)->delete();
    }

    public function getRepositoriesList()
    {
        $lista = [];
        do {
            $response = $this->client->get(isset($json['next']) ? $json['next'] : 'https://api.bitbucket.org/2.0/repositories/'. $this->getTeamName(), ['auth' => 'oauth']);
            $json = $response->json();
            foreach ($json['values'] as $val) {
                $lista[] = $val;
            }
        } while (isset($json['next']));

        return $lista;
    }


    public function getTeamName()
    {
        return config('services.bitbucket.team');
    }

    public function getTempName($prefix = 'zip')
    {
        return tempnam(sys_get_temp_dir(), $prefix);
    }

    public function getBranches($repoFullName)
    {
        $branches = $this->client
            ->get('https://api.bitbucket.org/1.0/repositories/' . $repoFullName . '/branches', ['auth' => 'oauth'])
            ->json();
        return $branches;
    }

    /**
     * @param $repoFullName
     * @param $branch
     * @return array
     */
    public function download($repoFullName, $branch)
    {
        $prased = [];
        $temporary_name = $this->getTempName();
        $response = $this->client->get('https://bitbucket.org/' . $repoFullName . '/get/' . $branch . '.zip', ['auth' => 'oauth']);
        file_put_contents($temporary_name, $response->getBody());
        $zip = zip_open($temporary_name);
        if ($zip) {
            while ($zip_entry = zip_read($zip)) {
                $file_name = zip_entry_name($zip_entry);
                $file_name = $file_name[1];

                if (substr($file_name, '-1') != '/' && $file_name != '') {

                    if (zip_entry_open($zip, $zip_entry)) {
                        if(substr($file_name, '-3') == '.md') {
                            $contents = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                            $prased['course'][substr($file_name, '0', '-3')] = $contents;
                            zip_entry_close($zip_entry);
                        }else{
                            $prased['other'][$file_name] = zip_entry_filesize($zip_entry);
                        }
                    }
                }
            }
        }
        return($prased);
    }
}