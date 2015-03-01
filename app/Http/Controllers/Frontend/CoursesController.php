<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\CourseRepository;
use App\Repositories\SourceRepository;


class CoursesController extends Controller {

	public function index(CourseRepository $courseRepository, $course, $version = 'master', $page = 'toc')
	{
        $courses = $courseRepository->getList();

        if(!isset($courses[$course]) || !in_array($version, $courses[$course]))
            abort(404);

        $toc = $courseRepository->get($course, $version, 'toc');

        list($coursetxt, $metadata) = $courseRepository->get($course, $version, $page);

        $courses[$course] = array_diff($courses[$course], ['develop']);


        if(isset($metadata['source']))
        {
            $sources = [];
            foreach ($metadata['source'] as $k=>$s) {
                if(is_numeric($k))
                    $sources[] = $s;
                else
                    $sources[] = link_to($s, $k);
            }
            $sources = implode(', ', $sources);
        }else{
            $sources = null;
        }


		return view('frontend.course', [
            'currentVersion' => $version,
            'versions' => $courses[$course],
            'currentManual' => $course,
            'manuals' => array_keys($courses),
            'date' => isset($metadata['date']) ? implode(', ', $metadata['date']) : null,
            'author' => isset($metadata['author']) ? implode(', ', $metadata['author']) : null,
            'reviewer' => isset($metadata['reviewer']) ? implode(', ', $metadata['reviewer']) : null,
            'content' => $coursetxt,
            'sources' => $sources,
            'toc' => $toc[0]
        ]);
	}

}
