<?php
session_start();
include 'constant.php';
include BASE_PATH . 'vendor/autoload.php';
include BASE_PATH . 'bootstrap/config.php';

$conn = new mysqli($config->host, $config->user, $config->pass, $config->db);
if ($conn->connect_errno) {
    die('This Connection is Not True , ERROR is : ' . $conn->connect_error);
}
// connection is true
include BASE_PATH . 'libs/helpers.php';
include BASE_PATH . 'libs/libLocations.php';
include BASE_PATH . 'libs/libUsers.php';
