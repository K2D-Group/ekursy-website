<?php

namespace App\Repositories;


use App\CourseLesson;
use App\Helpers\MarkdownHelper;
use Storage;


class CourseRepository {

    function get(CourseLesson $lesson){
        return MarkdownHelper::parse($lesson->content, route('course', [$lesson->course->slug, $lesson->course->version]));
    }
    
}