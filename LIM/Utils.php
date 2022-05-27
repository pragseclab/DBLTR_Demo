<?php

function get_web_application_files($web_app_path) {
    return get_dir_contents($web_app_path);
}

/*
* Helper functions to get local www directories
*/
function get_dir_contents($dir, &$results = array())
{
    $files = scandir($dir);

    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            $results[] = $path;
        } else if ($value != "." && $value != "..") {
            get_dir_contents($path, $results);
        }
    }

    return $results;
}