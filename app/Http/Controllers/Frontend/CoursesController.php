<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\SourceRepository;

class CoursesController extends Controller {

	public function index()
	{
//        $r = new SourceRepository();
//        $r->get();

		return view('frontend.course');
	}

}
