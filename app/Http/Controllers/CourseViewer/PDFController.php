<?php namespace App\Http\Controllers\CourseViewer;

use App\Course;
use App\Http\Controllers\Controller;
use App\Repositories\CourseRepository;
use App\Repositories\SourceRepository;
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


//        dd($toc, $lista);


//        $courseRepository->get();


        $HTML = '';

        $mpdf=new mPDF('PL_pl', 'A5', null, null, 10, 10, 15, 15, 10, 10);
        $mpdf->mirrorMargins = 1;
        $mpdf->defaultPageNumStyle = '1';
        $mpdf->useOnlyCoreFonts = true;    // false is default
//        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle($course->name);
        $mpdf->SetAuthor("K2D");
        $mpdf->SetWatermarkText("DEMO");
        $mpdf->showWatermarkText = false;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->h2bookmarks = array('H1'=>0, 'H2'=>1, 'H3'=>2, 'H4'=>3);

        $mpdf->SetDisplayMode('fullpage', 'two');




        // Okładka
        $mpdf->AddPageByArray([]);
        $mpdf->WriteHTML('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css"><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css"><meta charset="utf-8">');
        $mpdf->WriteHTML('<h1>Okładka</h1>');

//        $mpdf->AddPageByArray([
////            'pagenumstyle' => 'a',
////            'resetpagenum' => 1
//        ]);

        // Stopka


        // Spis treści
        $mpdf->TOCpagebreakByArray(array(
            'links' => 'on',
            'toc-bookmarkText' => '',
            'toc-preHTML' => '',
            'resetpagenum' => 10
        ));





        $mpdf->AddPageByArray([
            'type' => 'next-even',
            'pagenumstyle' => '1',
            'resetpagenum' => 1
        ]);
        $mpdf->SetFooter($course->name.' | K2D ©2015 | {PAGENO}');



        foreach ($lista as $main) {
//            $HTML .= '<tocentry content="'.$main['name'].'" />';
//            $mpdf->TOC_Entry($main['name'],0);
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
                                $l = $courseRepository->get($lesson);
//                                $HTML .= '<pagebreak type="E" />';
//                                $HTML .= '<tocentry content="'.$sub['name'].'" level="1" />';
                                $mpdf->TOC_Entry($sub['name'],1);
                                $mpdf->WriteHTML($l[0]);
                                $mpdf->AddPage(null, 'next-even');
//                                dd($l);
                            }
                        }
                    }
                }
            }
        }



//        $HTML = str_replace('<table>', '<table class="table table-striped table-bordered">', $HTML);


//        return $HTML;

//        $mpdf->WriteHTML($HTML);


//        return $mpdf->Output();
        $mpdf->Output(base_path('tmp/tmp.pdf'));
//        return $this->makeBooklet(base_path('tmp/tmp.pdf'));

    }
    function makeBooklet($file){
        $mpdf=new mPDF('','A4-L','','',0,0,0,0,0,0);
        $mpdf->SetImportUse();
        $ow = $mpdf->h;
        $oh = $mpdf->w;
        $pw = $mpdf->w / 2;
        $ph = $mpdf->h;

        $mpdf->SetDisplayMode('fullpage');

        $pagecount = $mpdf->SetSourceFile($file);
        $pp = $this->GetBookletPages($pagecount);

        foreach($pp AS $v) {
            $mpdf->AddPage();
            if ($v[0]>0 & $v[0]<=$pagecount) {
                $tplIdx = $mpdf->ImportPage($v[0], 0,0,$ow,$oh);
                $mpdf->UseTemplate($tplIdx, 0, 0, $tplIdx->w, $tplIdx->h);
            }
            if ($v[1]>0 & $v[1]<=$pagecount) {
                $tplIdx = $mpdf->ImportPage($v[1], 0,0,$ow,$oh);
                $mpdf->UseTemplate($tplIdx, $pw, 0, $tplIdx->w, $tplIdx->h);
            }
        }

        return $mpdf->Output();
    }
    function GetBookletPages($np, $backcover=true) {
        $lastpage = $np;
        $np = 4*ceil($np/4);
        $pp = array();
        for ($i=1; $i<=$np/2; $i++) {
            $p1 = $np - $i + 1;
            if ($backcover) {
                if ($i == 1) { $p1 = $lastpage; }
                else if ($p1 >= $lastpage) { $p1 = 0; }
            }
            if ($i % 2 == 1) {
                $pp[] = array( $p1,  $i );
            }
            else {
                $pp[] = array( $i, $p1 );
            }
        }
        return $pp;
    }

}
