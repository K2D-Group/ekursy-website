<?php namespace App\Http\Controllers\CourseViewer;

use App\Course;
use App\Helpers\PDFCourseHelper;
use App\Http\Controllers\Controller;
use App\Repositories\CourseRepository;
use App\Repositories\SourceRepository;
use Auth;
use mPDF;


class PDFController extends Controller {

	public function get(CourseRepository $courseRepository, $course_name, $current_version, $type=0)
	{
        $this->protect('course.pdf');

        $course = Course::whereSlug($course_name)->whereVersion($current_version)->first();
        if(is_null($course))
            abort(404);
        $toc = $course->lessons()->whereSlug('toc')->firstOrFail();

        $toc = explode("\n", $toc->content);

        if(!\Permissions::can('course.pdf.whitelabel'))
            $branded = true;
        else
            $branded = !(bool)\Request::get('nobranding', false);



        $RememberKey = 'course_pdf.' . $course_name . '.' . $current_version . '.' . $type . '.' . \Auth::user()->id . '.';
        $RememberKey .= $branded ? 'true' : 'false';
        $PDF = \Cache::remember($RememberKey, 60, function () use ($toc, $type, $course, $courseRepository, $branded) {
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

            switch($type){
                case 2:
                    if(!\Permissions::can('course.pdf.booklet'))
                        abort(404);
                    break;
            }

            $PDF = new PDFCourseHelper($course, $type, false);

            if($branded) {
                $PDF->setPDFOwner(\Auth::user());
            }

            $PDF->addFrontPages();


            $infoAboutPages = [];
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
                                    $infoAboutPages[$main['name']][$sub['name']] = $l[1];
                                }
                            }
                        }
                    }
                }
            }
            $PDF->addViewdata('info', $infoAboutPages);
            $PDF->addBackPages();
            return $PDF->output();
        });

        $download = false;
        $filename = $branded ? '' : ' - White Label';
        switch($type){
            case 2:
                $filename = 'BOOKLET - '.$course->name.' ('.$current_version.')'.$filename.'.pdf';
                $download = true;
                break;
            case 1:
                $filename = 'eBook - '.$course->name.' ('.$current_version.')'.$filename.'.pdf';
                break;
            case 0:
            default:
                $filename = ''.$course->name.' ('.$current_version.')'.$filename.'.pdf';
                break;
        }
        if(\Request::get('gen', 0) == 1)
            return [
                'status'=>'ok',
                'link'=>\Request::url().'?nobranding='.($branded?0:1),
                'name'=>$filename,
                'target'=>$download ? '' : '_blank',
            ];
        $resp = response($PDF)->header('Content-Type', 'application/pdf');
        if($download)
            $resp = $resp->header('Content-Disposition', 'attachment; filename='.$filename.';');
        else
            $resp = $resp->header('Content-Disposition', 'inline; filename='.$filename.';');
        return $resp;
    }

}
