<?php
include '../bootstrap/init.php';
if (!(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
    die("REQUEST ISN'T AJAX");
}

if ($_POST['action'] == 'activeLoc' and in_array($_POST['status'], [0, 1]) and is_numeric($_POST['id'])) {
    changeStatus($_POST['status'], $_POST['id']);
}

if ($_POST['action'] == 'searchLoc' and is_string($_POST['value'])) {
    $locations = searchLoc($_POST['value']);
    if (!is_null($locations)) {
        foreach ($locations as $location) {
            $type = LOCATION_TYPE[$location['type']];
            $href = BASE_URL . "?loc={$location['id']}";
            echo "<a href='{$href}' id='resultSearchLink'><div class='eleman' id='searchLocResult'><span class='category'>$type</span><span class='title'> $location[title] </span></div></a>";
        }
    } else {
        echo "<div class='locNotExist'>مکان مورد نظر شما پیدا نشد.</div>";
    }
}


if ($_POST['action'] == 'filterLocation') {
    $area = explode('=', explode('&', $_POST['value'])[0])[1];
    $locType = explode('=', explode('&', $_POST['value'])[1])[1];
    // echo "area = $area ---- locType = $locType ----- userLat = $_POST[userLat]  ----- userLng = $_POST[userLng]";
    $result = listOfVerifideLoc($area, $locType, $_POST['userLat'], $_POST['userLng']);
    if (!is_null($result)) {
        foreach ($result as $value) {
            $distance = getDistance($value['lat'], $value['lng'], $_POST['userLat'], $_POST['userLng']);
            $distance = round($distance, 4);
            echo "<a href='?loc={$value['id']}'><div class='resultFilterElement'>
                    <span>$value[title]</span>
                    <span>{$distance}km</span>
                </div></a>";
        }
    } else {
        echo "<span class'locNotExist'>چنین مکانی وجود ندارد</span>";
    }
}
