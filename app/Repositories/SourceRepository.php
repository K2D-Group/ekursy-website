<?php

namespace App\Repositories;
use App\Course;
use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class SourceRepository {

    private $client;

    function __construct()
    {
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
        foreach ($this->getRepositoriesList() as $repo) {
            if(substr($repo['name'], 0, 7) != 'Kurs - ')
                continue;

            $branches = $this->getBranches($repo['full_name']);
            foreach ($branches as $branch_name => $branch) {
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
                $only_existing_courses[] = [$slug, $branch_name];
                $Course->name = $repo['name'];
                $Course->save();



                $this->download($repo['full_name'], $branch_name);
            }
        }


        //Kasowanie pozostałych kursów
        $x = Course::withTrashed();
        foreach ($only_existing_courses as $c) {
            $x->WhereRaw('NOT (slug = ? and version = ?)', $c);
        }
        $x->delete();
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
        $repoName = explode('/', $repoFullName);
        $repoName = $repoName[1];

        $temporary_name = $this->getTempName();
        $response = $this->client->get('https://bitbucket.org/' . $repoFullName . '/get/' . $branch . '.zip', ['auth' => 'oauth']);
        file_put_contents($temporary_name, $response->getBody());
        $zip = zip_open($temporary_name);
        if ($zip) {
            while ($zip_entry = zip_read($zip)) {
                $file_name = zip_entry_name($zip_entry);
                $file_name = explode('/', $file_name, 2);
//                $file_name = $repoName.'/'.$branch.'/'.$file_name[1];
                $file_name = $file_name[1];

                if (substr($file_name, '-1') != '/' && $file_name != '') {

                    if (zip_entry_open($zip, $zip_entry)) {
                        if(substr($file_name, '-3') == '.md') {
                            $prased['course'][substr($file_name, '0', '-3')] = zip_entry_filesize($zip_entry);
                            $contents = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
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