<?php
// Check if a string is JSON
function is_json($string) {
    return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}

function convert_headers($headerArray) {
        foreach($headerArray as $key => $header) {
            $headers[] = "{$key}: $header";
        }

        return $headers;
}

function readDotEnv($filename = '.env') {
    $env = file_get_contents(__DIR__."/../{$filename}");
    $lines = explode("\n",$env);

    foreach($lines as $line){
        preg_match("/([^#]+)\=(.*)/",$line,$matches);
            if(isset($matches[2])){
            putenv(trim($line));
        }
    } 
}
