<?php

namespace App\Repositories;


use App\CourseLesson;
use App\Helpers\MarkdownHelper;
use Storage;


class CourseRepository {

    function getList(){
        $courses = [];
        foreach (Storage::disk('local')->directories('/') as $course) {
            foreach (Storage::disk('local')->directories('/'.$course.'/') as $version) {
                $courses[$course][] = basename($version);
            }
        }
        return $courses;
    }

    function get(CourseLesson $lesson){
        return MarkdownHelper::parse($lesson->content, route('course', [$lesson->course->slug, $lesson->course->version]));
    }
    
}