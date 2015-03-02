<?php

namespace App\Repositories;


use App\CourseLesson;
use App\Helpers\MarkdownHelper;
use Storage;


class CourseRepository {
    public $abbr = '';
    //*[MarkDown]: język znaczników przeznaczony do formatowania tekstu
    //*[HTML]: hipertekstowy język znaczników
    //*[Metadane]: Zbiór informacji o dokumencie i jego autorach
    //*[paragraf]: inaczej akapit


    function get(CourseLesson $lesson, $pdf = false){
        $abbr = "\n\n".$this->abbr;
        return MarkdownHelper::parse($lesson->content.$abbr, route('course', [$lesson->course->slug, $lesson->course->version]), $pdf);
    }
    
}