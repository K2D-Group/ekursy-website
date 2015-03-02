<?php namespace App\Http\Controllers\CourseViewer;

use App\Course;
use App\Http\Controllers\Controller;
use App\Repositories\CourseRepository;
use App\Repositories\SourceRepository;


class CoursesController extends Controller {



    public function pdf(CourseRepository $courseRepository, $course_name, $current_version = 'master')
    {
        list($course, $courses_list, $versions_list, $toc, $current_lesson) = $this->GetCourseInfo($courseRepository, $course_name, $current_version, 'toc');

        list($content, $metadata) = $courseRepository->get($current_lesson);

        if(is_null($content))
            abort(404);


        return view('course_viewer.pdf_gen', [
            'currentVersion' => $current_version,
            'versions' => $versions_list,
            'currentManual' => $course->slug,
            'manuals' => $courses_list,
            'title' => 'Pobierz plik PDF',
            'toc' => $toc[0],
            'ajaxLink' => route('course.pdf.make', [$course_name, $current_version, \Request::get('print', 0)]),
            'nobranding' => \Request::get('nobranding', 0)
        ]);
    }



    public function index(CourseRepository $courseRepository, $course_name, $current_version = 'master', $page = 'toc')
    {
        list($course, $courses_list, $versions_list, $toc, $current_lesson) = $this->GetCourseInfo($courseRepository, $course_name, $current_version, $page);

        list($content, $metadata) = $courseRepository->get($current_lesson);

        if(is_null($content))
            abort(404);


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

    /**
     * @param CourseRepository $courseRepository
     * @param $course_name
     * @param $current_version
     * @param $page
     * @return array
     */
    protected function GetCourseInfo(CourseRepository $courseRepository, $course_name, $current_version, $page)
    {
        if (\Auth::check() && \Permissions::can('course.devversion')) {
            $course = \Cache::remember('course.develop.' . $course_name . '.' . $current_version, 5, function () use ($course_name, $current_version) {
                return Course::whereSlug($course_name)->whereVersion($current_version)->first();
            });

            if (is_null($course))
                abort(404);

            $courses_list = \Cache::remember('courses_list.develop', 5, function () {
                return Course::groupBy('slug')->orderBy('name', 'asc')->get()->lists('name', 'slug');
            });

            $versions_list = \Cache::remember('versions_list.develop.' . $course_name, 5, function () use ($course_name) {
                return Course::whereSlug($course_name)->orderBy('version', 'asc')->get()->lists('version', 'version');
            });

            $toc = \Cache::remember('course.toc.' . $course_name . '.' . $current_version, 5, function () use ($courseRepository, $course) {
                return $courseRepository->get($course->lessons()->whereSlug('toc')->firstOrFail());
            });

            $current_lesson = \Cache::remember('course.page.' . $course_name . '.' . $current_version . '.' . $page, 5, function () use ($course, $page) {
                return $course->lessons()->whereSlug($page)->with('course')->first();
            });
            return array($course, $courses_list, $versions_list, $toc, $current_lesson);
        } else {
            $course = \Cache::remember('course.' . $course_name . '.' . $current_version, 60 * 12, function () use ($course_name, $current_version) {
                return Course::where('version', '!=', 'develop')->whereSlug($course_name)->whereVersion($current_version)->first();
            });

            if (is_null($course))
                abort(404);

            $courses_list = \Cache::remember('courses_list', 60 * 12, function () {
                return Course::where('version', '!=', 'develop')->groupBy('slug')->orderBy('name', 'asc')->get()->lists('name', 'slug');
            });

            $versions_list = \Cache::remember('versions_list.' . $course_name, 60 * 12, function () use ($course_name) {
                return Course::where('version', '!=', 'develop')->whereSlug($course_name)->orderBy('version', 'asc')->get()->lists('version', 'version');
            });

            $toc = \Cache::remember('course.toc.' . $course_name . '.' . $current_version, 60 * 12, function () use ($courseRepository, $course) {
                return $courseRepository->get($course->lessons()->whereSlug('toc')->firstOrFail());
            });

            $current_lesson = \Cache::remember('course.page.' . $course_name . '.' . $current_version . '.' . $page, 60 * 12, function () use ($course, $page) {
                return $course->lessons()->whereSlug($page)->with('course')->first();
            });
            return array($course, $courses_list, $versions_list, $toc, $current_lesson);
        }
    }

}
