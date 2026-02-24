<?php
function dd($content)
{
    echo '<pre>';
    var_dump($content);
    echo '</pre>';
    die();
}

function base_path($location)
{
    return BASE_PATH . $location;
}

function view_path($folder, $viewLocation, $attributes = [])
{
    //turn the associative array into normal variable with values
    extract($attributes);
    return require base_path("view/{$folder}/{$viewLocation}.php");
}

function abort($status = 404)
{
    http_response_code($status);
    require base_path("view/status/{$status}.php");
    die();
}