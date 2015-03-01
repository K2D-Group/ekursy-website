<?php namespace App\Http\Controllers\CourseViewer;

use App\Course;
use App\Http\Controllers\Controller;
use App\Repositories\CourseRepository;
use App\Repositories\SourceRepository;


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
                var_dump($matches);

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


        dd($toc, $lista);
	}

}
