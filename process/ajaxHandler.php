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
