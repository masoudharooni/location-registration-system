<?php
include 'bootstrap/init.php';

if (!isUserLoggedIn()) {
    header("location: auth.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btn']) and $_POST['btn'] == 'ثبت') {
        if (!empty($_POST['lat']) and !empty($_POST['lng']) and !empty($_POST['name']) and !empty($_POST['type'])) {
            addLoc($_POST['lat'], $_POST['lng'], $_POST['name'], $_POST['type']);
            header("location:" . BASE_URL . "?completed=ok");
        } else {
            header("location:" . BASE_URL . "?notCompleted=ok");
        }
    }
}

$singleLoc = null;
if (isset($_GET['loc']) and is_numeric($_GET['loc'])) {
    $singleLoc = getSingleLoc($_GET['loc']);
}

$veriFideLocations = listOfVerifideLoc();


$userLocationProfile = userLocationsProfile($_SESSION['userLogin']['id']);

if (isset($_GET['userLogout']) and in_array($_GET['userLogout'], [0, 1])) {
    userLogout();
}

if (isset($_GET['deleteLoc']) and is_numeric($_GET['deleteLoc'])) {
    deleteLocation($_GET['deleteLoc']);
    header("Location:" . BASE_URL);
}

include 'views/tpl-index.php';
