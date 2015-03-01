<?php namespace App\Http\Controllers\CourseViewer;

use App\Course;
use App\Http\Controllers\Controller;
use App\Repositories\CourseRepository;
use App\Repositories\SourceRepository;


class CoursesController extends Controller {

	public function index(CourseRepository $courseRepository, $course_name, $current_version = 'master', $page = 'toc')
	{
        $course = Course::whereSlug($course_name)->whereVersion($current_version)->first();
        if(is_null($course))
            abort(404);

        $toc = $courseRepository->get($course->lessons()->whereSlug('toc')->firstOrFail());

        $current_lesson = $course->lessons()->whereSlug($page)->first();
        list($content, $metadata) = $courseRepository->get($current_lesson);

        if(is_null($content))
            abort(404);

        $courses_list = Course::where('version', '!=', 'develop')->groupBy('slug')->orderBy('name', 'asc')->get()->lists('name', 'slug');
        $versions_list = Course::where('version', '!=', 'develop')->whereSlug($course_name)->orderBy('version', 'asc')->get()->lists('version', 'version');

        if(!empty($current_lesson->sources))
        {
            $sources = [];
            foreach ($current_lesson->sources as $k=>$s) {
                if(is_null($s))
                    $sources[] = $k;
                else
                    $sources[] = link_to($s, $k);
            }
            $sources = implode(', ', $sources);
        }else{
            $sources = null;
        }

        $view = 'course_viewer.course';

        if($current_lesson->need_login == true && \Auth::guest())
            $view = 'course_viewer.noaccess';


        return view($view, [
            'currentVersion' => $current_version,
            'versions' => $versions_list,
            'currentManual' => $course->slug,
            'manuals' => $courses_list,
            'title' => $current_lesson->name,
            'date' => !empty($current_lesson->updates) ? implode(', ', $current_lesson->updates) : null,
            'author' => !empty($current_lesson->authors) ? implode(', ', $current_lesson->authors) : null,
            'reviewer' => !empty($current_lesson->reviewers) ? implode(', ', $current_lesson->reviewers) : null,
            'content' => $content,
            'sources' => $sources,
            'toc' => $toc[0]
        ]);
	}

}
