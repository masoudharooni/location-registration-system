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

function toggleToLatLng(int $km)
{
    $lat = $km * 0.01;
    return $lat;
}

function getDistance($lat1, $lon1, $lat2, $lon2)
{
    $rad = M_PI / 180;
    $radius = 6371; //earth radius in kilometers
    return acos(sin($lat2 * $rad) * sin($lat1 * $rad) + cos($lat2 * $rad) * cos($lat1 * $rad) * cos($lon2 * $rad - $lon1 * $rad)) * $radius; //result in Kilometers
}
