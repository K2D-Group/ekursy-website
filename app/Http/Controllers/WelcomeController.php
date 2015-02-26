<?php namespace App\Http\Controllers;

use App\Repositories\SourceRepository;

class WelcomeController extends Controller {

	public function index()
	{
        return redirect()->route('course', ['kurs-php', 'master']);
	}

}
