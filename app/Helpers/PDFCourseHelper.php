<?php
/**
 * Created by PhpStorm.
 * User: kduma
 * Date: 02/03/15
 * Time: 14:40
 */

namespace App\Helpers;


use App\Course;
use App\User;
use mPDF;

/**
 * Class PDFCourseHelper
 * @package App\Helpers
 */
class PDFCourseHelper {

    /**
     * @var Course
     */
    private $course;

    /**
     * @var int
     */
    private $type;

    /**
     * @var array
     */
    private $types = [
        0 => [
            'size' => 'A5',
            'booklet' => false,
            'mirrorMargins' => 0,
            'start-on-even' => false,
            'output' => 'I',
            'output_name' => 'PDF',
        ],
        1 => [
            'size' => 'A5',
            'booklet' => false,
            'mirrorMargins' => 1,
            'start-on-even' => true,
            'output' => 'I',
            'output_name' => 'E-Book',
        ],
        2 => [
            'size' => 'A5',
            'booklet' => true,
            'mirrorMargins' => 1,
            'start-on-even' => true,
            'output' => 'D',
            'output_name' => 'BookLet',
        ]
    ];

    /**
     * @var mPDF
     */
    private $mpdf;

    /**
     * @var bool
     */
    private $download=false;


    /**
     * @param array $viewdata
     */
    public function addViewdata($key, $value)
    {
        $this->viewdata[$key] = $value;
    }

    /**
     * @var array
     */
    private $viewdata = [];

    /**
     * @param Course $course
     * @param int $type
     * @throws \Exception
     */
    function __construct(Course $course, $type, $download=true)
    {
        $this->course = $course;
        $this->addViewdata('course', $course);

        if(!isset($this->types[$type]))
            throw new \Exception('Type doesn\'t exist.');

        $this->type = $this->types[$type];
        $this->addViewdata('type', $this->type);

        $this->mpdf = new mPDF('PL_pl', $this->type['size'], null, null, 5, 5, 15, 15, 5, 5);
        $this->mpdf->max_colH_correction = 1;
        $this->mpdf->mirrorMargins = $this->type['mirrorMargins'];

        $this->mpdf->defaultPageNumStyle = '1';
        $this->mpdf->useOnlyCoreFonts = true;    // false is default

        if(!$this->type['booklet'])
            $this->mpdf->SetProtection(array('print'));

        $this->mpdf->SetTitle($course->name);
        $this->mpdf->SetAuthor(config('app.name.full'));



        $this->mpdf->h2bookmarks = array('H1'=>0, 'H2'=>1, 'H3'=>2, 'H4'=>3);

        $this->mpdf->SetDisplayMode('fullpage', 'two');

        $this->download = $download;
    }

    /**
     * Makes PDF branded for specific user
     *
     * @param User $user
     */
    function setPDFOwner(User $user){
        $this->mpdf->SetWatermarkText("ekursy.cf");
        $this->mpdf->showWatermarkText = true;
        $this->mpdf->watermark_font = 'DejaVuSansCondensed';
        $this->mpdf->watermarkTextAlpha = 0.1;

        $this->mpdf->SetHeader('Kopia wygenerowana dla: '.$user->name.' ('.$user->email.')');
    }

    /**
     *
     */
    function addFrontPages(){
        $this->mpdf->AddPageByArray([]);

        // TODO: Remove bootstrap
        $this->mpdf->WriteHTML('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css"><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css"><meta charset="utf-8">');
        $this->mpdf->WriteHTML(view('course_pdf.front_cover', $this->viewdata)->render());

        $this->mpdf->AddPageByArray([
            'pagenumstyle' => 'a',
            'resetpagenum' => 1
        ]);

        $this->SetFooter(false);

        $this->mpdf->WriteHTML(view('course_pdf.second_page', $this->viewdata)->render());


        // Spis treści
        $this->mpdf->TOCpagebreakByArray(array(
            'links' => 'on',
            'toc-bookmarkText' => 'Spis Treści',
            'toc-preHTML' => '<h1>Spis Treści</h1>',
        ));



        $this->mpdf->AddPageByArray([
            'type' => 'next-even',
            'pagenumstyle' => '1',
            'resetpagenum' => 1
        ]);

        $this->SetFooter(true);
    }


    /**
     * @param $txt
     * @param int $level
     */
    function TOC_Entry($txt, $level=0){
        return $this->mpdf->TOC_Entry($txt, $level);
    }

    /**
     * @param $html
     */
    function AddPage($html){
        $this->mpdf->WriteHTML($html);
//        if($this->type['start-on-even'])
//            $this->mpdf->AddPage(null, 'next-even');
//        else
            $this->mpdf->AddPage();
    }


    /**
     *
     */
    function addBackPages(){
        $this->SetFooter(false);

        $this->TOC_Entry('Informacje dodatkowe');
        $this->mpdf->WriteHTML(view('course_pdf.last_page', $this->viewdata)->render());
        $this->mpdf->AddPage();



        if($this->type['mirrorMargins'])
            while( ((4-((count($this->mpdf->pages)+2) % 4)) % 4) != 0){
                $this->mpdf->AddPage();
            }

        $this->mpdf->WriteHTML(view('course_pdf.back_cover', $this->viewdata)->render());
    }


    /**
     * @return mixed
     */
    function output(){
        if(!$this->type['booklet'])
            if($this->download)
                return $this->mpdf->Output($this->type['output_name'].' - '.$this->course->name.' (' . $this->course->version . ').pdf', $this->type['output']);
            else
                return $this->mpdf->Output(null, 'S');

        $tmpname = $this->getTempName();
        $this->mpdf->Output($tmpname);
        return $this->makeBooklet($tmpname);
    }


    /**
     * Sets Footer
     *
     * @param $pageNumbering
     */
    protected function SetFooter($pageNumbering)
    {
        if($this->type['mirrorMargins'])
            if(!$pageNumbering)
                $this->mpdf->SetFooter($this->course->name . ' (' . $this->course->version . ') | '.config('app.copyright.name').' ©'.Config('app.copyright.year'));
            else
                $this->mpdf->SetFooter($this->course->name . ' (' . $this->course->version . ') | '.config('app.copyright.name').' ©'.Config('app.copyright.year').' | {PAGENO}');
        else
            if(!$pageNumbering)
                $this->mpdf->SetFooter($this->course->name . ' (' . $this->course->version . ') | | '.config('app.copyright.name').' ©'.Config('app.copyright.year'));
            else
                $this->mpdf->SetFooter($this->course->name . ' (' . $this->course->version . ') | {PAGENO} | '.config('app.copyright.name').' ©'.Config('app.copyright.year').'');
    }


    /**
     * @param $file
     * @return mixed
     */
    private function makeBooklet($file){
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

        if($this->download)
            return $mpdf->Output($this->type['output_name'].' - '.$this->course->name.' (' . $this->course->version . ').pdf', $this->type['output']);
        else
            return $mpdf->Output(null, 'S');
    }

    /**
     * @param $np
     * @param bool $backcover
     * @return array
     */
    private function GetBookletPages($np, $backcover=true) {
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

    /**
     * @param string $prefix
     * @return string
     */
    private function getTempName($prefix = 'pdf')
    {
        return tempnam(sys_get_temp_dir(), $prefix);
    }

}