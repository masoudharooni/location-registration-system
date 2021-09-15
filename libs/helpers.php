<?php
function dd(array $array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
    die();
}

function siteUrl(string $query_string = null)
{
    return BASE_URL . $query_string;
}
