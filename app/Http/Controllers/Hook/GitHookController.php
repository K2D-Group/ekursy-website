<?php namespace App\Http\Controllers\Hook;

use App\Http\Controllers\Controller;
use App\Repositories\SourceRepository;

class GitHookController extends Controller {

	public function bitbucket()
	{
		$data = \Request::get('payload', '{}');
	    $data = json_decode($data, true);

        if(empty($data))
            return;

        if(substr($data['repository']['name'], 0, 7) != 'Kurs - ')
            return;

        $branches = [];
        foreach ($data['commits'] as $commit) {
            if(substr($commit['branch'], 0, 1) != 'v' && $commit['branch'] != 'develop')
                continue;
            $branches[$commit['branch']] = $commit['branch'];
        }

        if(empty($branches))
            return;

        (new SourceRepository)->get();

    }

}
