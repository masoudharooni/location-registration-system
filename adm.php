<?php
include 'bootstrap/init.php';


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!empty($_POST['username']) and !empty($_POST['password'])) {
        if (!login($_POST['username'], $_POST['password'])) {
            echo "<script>alert('کلمه ی عبور یا نام کاربری صحیح نمی باشید.')</script>";
        }
    } else {
        echo "<script>alert('اطلاعات فرم را کامل وارد کنید.')</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['logout']) and $_GET['logout'] == true) {
        logout();
    }
}

if (isLoggedIn()) {
    $params = $_GET ?? [];
    // dd($params);
    $locations = getLocations($params);
    // dd($locations);
    include 'views/tpl-adm.php';
} else {
    include 'views/tpl-auth.php';
}
