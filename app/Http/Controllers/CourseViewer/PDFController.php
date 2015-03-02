<?php namespace App\Http\Controllers\CourseViewer;

use App\Course;
use App\Helpers\PDFCourseHelper;
use App\Http\Controllers\Controller;
use App\Repositories\CourseRepository;
use App\Repositories\SourceRepository;
use Auth;
use mPDF;


class PDFController extends Controller {

	public function get(CourseRepository $courseRepository, $course_name, $current_version)
	{
        $course = Course::whereSlug($course_name)->whereVersion($current_version)->first();
        if(is_null($course))
            abort(404);
        $toc = $course->lessons()->whereSlug('toc')->firstOrFail();

        $toc = explode("\n", $toc->content);


        $lista = [];
        $i = 0;
        foreach($toc as &$t){
            if(preg_match("/^([\\t ]*)- (\\[([^\\]]*)\\]\\(([^\\)]*)\\)|([^\\n]*))/us", $t, $matches)){
                $matches[1] = str_replace("\t", "    ", $matches[1]);
                if(strlen($matches[1]) == 0){
                    if($matches[3] == '')
                        $lista[$i++] = [
                            'name' => $matches[2],
                            'file' => null,
                            'submenu' => []
                        ];
                    else
                        $lista[$i++] = [
                            'name' => $matches[3],
                            'file' => $matches[4],
                            'submenu' => []
                        ];
                }else{
                    if($matches[3] == '')
                        $lista[$i-1]['submenu'][] = [
                            'name' => $matches[2],
                            'file' => null
                        ];
                    else
                        $lista[$i-1]['submenu'][] = [
                            'name' => $matches[3],
                            'file' => $matches[4]
                        ];
                }
            }
        }
        switch(\Request::get('print', 0)){
            case 2:
                if(!\Permissions::can('course.pdf.booklet'))
                    abort(404);
                break;
        }

        $PDF = new PDFCourseHelper($course, \Request::get('print', 0));

        if(!\Permissions::can('course.pdf.whitelabel')) {
            $PDF->setPDFOwner(\Auth::user());
        }

        $PDF->addFrontPages();

        foreach ($lista as $main) {
            $PDF->TOC_Entry($main['name'],0);
            if($main['file'] != ''){
                // TODO
            }
            if(isset($main['submenu']) && !empty($main['submenu'])) {
                foreach ($main['submenu'] as $sub) {
                    if($sub['file'] != ''){
                        if(substr($sub['file'], -3) == '.md'){
                            $sub['file'] = substr($sub['file'], 0, -3);
                            $lesson = $course->lessons()->whereSlug($sub['file'])->first();
                            if(!is_null($lesson)){
                                $l = $courseRepository->get($lesson, true);
                                $PDF->TOC_Entry($sub['name'],1);
                                $PDF->AddPage($l[0]);
                            }
                        }
                    }
                }
            }
        }

        $PDF->addBackPages();
        $PDF->output();




    }

}
