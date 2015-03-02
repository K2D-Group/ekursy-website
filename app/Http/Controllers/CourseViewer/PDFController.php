<?php namespace App\Http\Controllers\CourseViewer;

use App\Course;
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

        $mpdf=new mPDF('PL_pl', 'A5', null, null, 5, 5, 15, 15, 5, 5);

        if(\Request::get('print') == 0)
            $mpdf->mirrorMargins = 0;
        else
            $mpdf->mirrorMargins = 1;

        $mpdf->defaultPageNumStyle = '1';
        $mpdf->useOnlyCoreFonts = true;    // false is default

        if(\Request::get('print') != 2)
            $mpdf->SetProtection(array('print'));

        $mpdf->SetTitle($course->name);
        $mpdf->SetAuthor(config('app.name.full'));

        if(!\Permissions::can('course.pdf.whitelabel')) {
            $mpdf->SetWatermarkText("ekursy.cf");
            $mpdf->showWatermarkText = true;
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->watermarkTextAlpha = 0.1;

            $mpdf->SetHeader('Kopia wygenerowana dla: '.Auth::user()->name.' ('.Auth::user()->email.')');
        }

        $mpdf->h2bookmarks = array('H1'=>0, 'H2'=>1, 'H3'=>2, 'H4'=>3);

        $mpdf->SetDisplayMode('fullpage', 'two');






        // Okładka
        $mpdf->AddPageByArray([]);
        $mpdf->WriteHTML('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css"><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css"><meta charset="utf-8">');
        $mpdf->WriteHTML('<h1>Okładka</h1>');

        $mpdf->AddPageByArray([
            'pagenumstyle' => 'a',
            'resetpagenum' => 1
        ]);
        $mpdf->SetFooter($course->name.' ('.$course->version.') | '.config('app.copyright.name').' ©'.Config('app.copyright.year'));

        $mpdf->WriteHTML('<h1>Strona Tytułowa</h1>');


        // Spis treści
        $mpdf->TOCpagebreakByArray(array(
            'links' => 'on',
            'toc-bookmarkText' => 'Spis Treści',
            'toc-preHTML' => '<h1>Spis Treści</h1>',
        ));





        $mpdf->AddPageByArray([
            'type' => 'next-even',
            'pagenumstyle' => '1',
            'resetpagenum' => 1
        ]);

        
        $mpdf->SetFooter($course->name.' ('.$course->version.') | '.config('app.copyright.name').' ©'.Config('app.copyright.year').' | {PAGENO}');



        foreach ($lista as $main) {
            $mpdf->TOC_Entry($main['name'],0);
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
                                $mpdf->TOC_Entry($sub['name'],1);
                                $mpdf->WriteHTML($l[0]);
//                                $mpdf->AddPage(null, 'next-even');
                                $mpdf->AddPage();
                            }
                        }
                    }
                }
            }
        }

        $mpdf->InsertIndex();
        $mpdf->AddPage();

        $mpdf->SetFooter($course->name.' ('.$course->version.') | '.config('app.copyright.name').' ©'.Config('app.copyright.year'));

        if(\Request::get('print') != 0)
        while( ((4-((count($mpdf->pages)+2) % 4)) % 4) != 0){
            $mpdf->AddPage();
        }
        $mpdf->WriteHTML('<h1>Tylna okładka</h1>');


        if(\Request::get('print') != 2)
            return $mpdf->Output();

        $tmpname = $this->getTempName();
        $mpdf->Output($tmpname);
        return $this->makeBooklet($tmpname);

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

    public function getTempName($prefix = 'pdf')
    {
        return tempnam(sys_get_temp_dir(), $prefix);
    }

}
