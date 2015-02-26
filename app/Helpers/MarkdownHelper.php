<?php
namespace App\Helpers;

use Kurenai\DocumentParser;
use Parsedown;

class MarkdownHelper
{
    public static function parse($text, $pathPrefix = '')
    {
        list($parsed, $metadata) = self::parseMeta($text);
        $basePath = $pathPrefix;
        $rendered = (new Parsedown)->text($parsed);

        // Replace absolute relative paths (paths that start with / but not //)
        $rendered = preg_replace('/href=\"(\/[^\/].+?).md(#?.*?)\"/', "href=\"$basePath$1$2\"", $rendered);

        // Replace relative paths (paths that don't start with / or http://, https://, //, etc)
        $rendered = preg_replace('/href=\"(?!.*?\/\/)(.+?).md(#?.*?)\"/', "href=\"$basePath/$1$2\"", $rendered);


        return [$rendered, $metadata];
    }


    public static function parseMeta($content, $extract = false)
    {
        $metadata_list = [];

        $content = str_replace(array("\r\n", "\r"), "\n", $content);
        $lines = explode("\n", $content);

        $divider = null;
        foreach ($lines as $no => $line) {
            if(trim($line) == ''){
                $divider = $no;
                break;
            }
        }
        if($divider != null){
            $metadata = array_slice($lines, 0, $divider);
            $content = array_slice($lines, $divider+1);


            $found = false;
            $last_key = null;
            foreach ($metadata as $line) {
                if(preg_match("/^([A-Za-z0-9][A-Za-z0-9 ]*):[\\t ]*([^\\n]*)$/us", $line, $matches)){
                    $metadata_list[$matches[1]][] = $matches[2];
                    $last_key = $matches[1];
                    $found = true;
                }elseif($found == true && preg_match("/^[\\t ]*([^\\n]*)$/us", $line, $matches)){
                    $metadata_list[$last_key][] = $matches[1];
                }elseif($found == false){
                    $metadata = null;
                    $content = $lines;
                    break;
                }else{
                    break;
                }
            }
            $metadata_list = array_change_key_case($metadata_list, CASE_LOWER);
        }else{
            $metadata = null;
            $content = $lines;
        }

        return [
            implode("\n", $content),
            $metadata_list
        ];
    }
}