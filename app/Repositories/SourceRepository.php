<?php

namespace App\Repositories;
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
        foreach ($this->getRepositoriesList() as $repo) {
            if(substr($repo['name'], 0, 7) != 'Kurs - ')
                continue;
            $branches = $this->getBranches($repo['full_name']);
            foreach ($branches as $branch_name => $branch) {
                $this->download($repo['full_name'], $branch_name);
            }
        }
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
     */
    public function download($repoFullName, $branch)
    {
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
                $file_name = $repoName.'/'.$branch.'/'.$file_name[1];

                if (substr($file_name, '-1') == '/') {
                    \Storage::disk('local')->makeDirectory($file_name);
                } else {
                    if (zip_entry_open($zip, $zip_entry)) {
                        $contents = zip_entry_read($zip_entry);
                        \Storage::disk('local')->put($file_name, $contents);
                        zip_entry_close($zip_entry);
                    }
                }
            }
        }
    }
}