<?php

namespace App\Repositories;


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

    function get($course, $version, $page){
        $path = '/'.$course.'/'.$version.'/'.$page.'.md';

        if (!Storage::disk('local')->exists($path))
            return false;

        $markdown = Storage::disk('local')->get($path);

        return MarkdownHelper::parse($markdown, route('course', [$course, $version]));
    }
    
}