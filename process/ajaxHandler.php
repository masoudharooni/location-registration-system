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
                    <span>فاصله : {$distance}km</span>
                </div></a>";
        }
    } else {
        echo "<span class'locNotExist'>چنین مکانی وجود ندارد</span>";
    }
}



if ($_POST['action'] == 'userRegister') {
    $expload = explode('&', $_POST['data']);
    $data = [
        'firstname' => explode('=', $expload[0])[1],
        'lastname' => explode('=', $expload[1])[1],
        'email' => explode('=', $expload[2])[1],
        'emailConfirm' => explode('=', $expload[3])[1],
        'password' => explode('=', $expload[4])[1],
        'passwordConfirm' => explode('=', $expload[5])[1]
    ];
    $registerResult = userRegister($data);
    echo $registerResult['alert'];
}


if ($_POST['action'] == 'userLogin') {
    $expload = explode('&', $_POST['data']);
    $data = [
        'email' => explode('=', $expload[0])[1],
        'password' => explode('=', $expload[1])[1]
    ];
    // var_dump($_POST);
    if (!userLogin($data)) {
        echo "ایمیل یا رمز ورود صحیح نمی باشد.";
    } else {
        echo true;
    }
}

if ($_POST['action'] == 'passRecover' and isset($_POST['data'])) {
    // var_dump($_POST);
    $expload = explode('&', $_POST['data']);
    $data = [
        'email' => explode('=', $expload[0])[1],
        'password' => explode('=', $expload[1])[1]
    ];
    // var_dump($data);
    if (isThereEmail($data['email'])) {
        if (isValidPass($data['password'])) {
            $code = sendEmail($data['email']);
            if (!is_null($code)) {
                echo "کدی که برای شما ایمیل شد را وارد کنید";
                $_SESSION['passRecovery'] = [
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'code' => $code
                ];
            }
        } else {
            echo "پسورد ایمن نیست.";
        }
    } else {
        echo "این ایمیل وجود ندارد ، ثبت نام کنید.";
    }
}


if ($_POST['action'] == 'passRecover' and isset($_POST['code'])) {
    if (isset($_SESSION['passRecovery'])) {
        if ($_SESSION['passRecovery']['code'] == $_POST['code']) {
            if (updatePassword($_SESSION['passRecovery']['email'], $_SESSION['passRecovery']['password'])) {
                echo "پسورد شما بروزرسانی شد ، لطفا وارد شوید.";
            } else {
                echo "پسورد شما بروزرسانی نشد ، مجددا تلاش کنید.";
            }
        } else {
            echo "کد تایید صحیح نمی باشد.";
        }
        unset($_SESSION['passRecovery']);
    }
}


if ($_POST['action'] == 'editLocationByAdmin') {
    $expload = explode('&', $_POST['data']);
    $data = [
        'name' => explode('=', $expload[0])[1],
        'type' => explode('=', $expload[1])[1]
    ];
    echo updateLocation($_POST['id'], $data['type'], $data['name']) ?? 'مکان بروزرسانی نشد ، مجددا تلاش کنید.';
}
