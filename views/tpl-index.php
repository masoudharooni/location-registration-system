<?php

use Hekmatinasser\Verta\Verta;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MH | MAP</title>
    <link href="assets/img/favicon.png" rel="shortcut icon" type="image/png">
    <link rel="stylesheet" href="assets/css/style.css" />
    <!--leaflet-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

    <!-- font awsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- bootstrap cdn -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <style>
        a {
            color: inherit;
        }

        a:hover {
            color: inherit;
        }

        .locResult span.notExist {
            text-align: center;
        }

        .profile {
            width: 32%;
            height: 80%;
            background: #257eca;
            z-index: 99999;
            position: absolute;
            bottom: 10%;
            border-radius: 50px 0 0 50px;
            display: none;
        }

        i.fas.fa-times.profileClose {
            color: red;
            font-size: 35px;
            position: relative;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .img {
            text-align: center;
            margin-top: 10px;
            border-bottom: 5px solid #fff;
        }

        .img img {
            width: 110px;
        }

        p.nameUser {
            font-size: 25px;
            font-family: sahelBlack;
            margin-top: 10px;
            color: #fff;
        }

        .info {
            border-bottom: 5px solid #fff;
        }

        .info p.title {
            color: #fff;
            font-size: 25px;
            text-align: center;
            font-family: 'sahelBlack';
            padding-top: 15px;
        }

        .info p:not(p.title) {
            font-family: sahel;
            color: #fff;
            padding: 0 20px;
        }

        .info p span {
            font-family: sahelBlack;
            padding-left: 10px;
        }

        .profileLocations {
            /* background-color: red; */
            padding: 10px 30px;
        }

        .profileLocations .title {
            text-align: center;
            font-family: sahelBlack;
            color: #fff;
            font-size: 22px;
        }

        .listOfLocations {
            background-color: #a2d6ff;
            height: 100px;
            overflow-y: scroll;
        }

        .listOfLocations .loc {
            border-bottom: 1px solid gray;
            padding: 10px;
            font-family: 'sahelBlack';
            cursor: pointer;
        }

        .listOfLocations .loc:hover {
            background-color: #82c0f1;
        }

        .listOfLocations .loc span:first-child {
            color: #444;
        }

        .listOfLocations .loc span:last-child {
            float: left;
            padding: 7px 15px;
            background-color: #ffffff;
            border-right: 3px solid #257eca;
            border-radius: 5px 20px 20px 5px;
            position: relative;
            bottom: 7px;
            color: #000;
            direction: rtl;
            transition: .3s;
        }

        .listOfLocations .loc span:last-child:hover {
            border-right: 15px solid #257eca;
            transition: .3s;
            border-radius: 5px 20px 20px 5px;
        }


        botton.userLogout {
            font-family: 'sahelBlack';
            color: #257eca;
            padding: 10px 30px;
            border-radius: 10px;
            background: #fff;
            position: relative;
            top: 20px;
            right: 25%;
            cursor: pointer;
            transition: .3s;
        }

        botton.userLogout:hover {
            border-radius: 0;
            transition: .3s;
        }

        .listOfLocations .locationNotExist {
            color: #000;
            font-family: 'sahelBlack';
            font-size: 20px;
            position: relative;
            top: 43%;
            right: 25%;
        }

        a {
            color: inherit;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="main">
        <div class="head">
            <input type="search" id="search" placeholder="دنبال کجا می گردی؟" autocomplete="off">
            <div class="locResult"></div>
        </div>
        <div class="mapContainer">
            <div id="map"></div>
        </div>
        <div class="buttons">
            <i id="userPanel" titles="اطلاعات شما!" class="fas fa-user clickable satellite titleAtr"></i>
            <i id="satellite" titles="حالت ماهواره ای!" class="fas fa-globe clickable satellite titleAtr"></i>
            <i id="filterBtn" titles="فیلتر کردن لوکیشن ها." class="fas fa-sort-amount-down-alt clickable satellite titleAtr"></i>
            <i id="defaultMap" titles="حالت اولیه!" class="fas fa-map-marked-alt clickable satellite titleAtr"></i>
            <i id="userLoc" titles="موقعیت مکانی شما" class="fas fa-compass satellite clickable titleAtr"></i>
        </div>
    </div>


    <div id="registerLoc" class="modall">
        <div class="modalMain">
            <button class="modalClose"><i class="fas fa-times clickable"></i></button>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="element">
                    <label for="forLoc">مختصات:</label>
                    <div class="input showLoc">
                        طول جغرافیایی : <input type="text" id="lat-display" name="lat" style="border: none;" readonly>
                        عرض جغرافیایی : <input type="text" id="lng-display" name="lng" style="border: none;" readonly>
                    </div>
                </div>
                <div class="element">
                    <label for="locName">نام مکان:</label>
                    <input id="locName" type="text" name="name" class="form-control input" placeholder="مانند : میدان نقش جهان" aria-label="" aria-describedby="basic-addon1" autocomplete="off">
                </div>
                <div class="element">
                    <label for="category">نوع مکان : </label>
                    <select name="type" id="category" class="form-select input" aria-label="Default select example">
                        <option selected value="">نوع مکان مورد نظر خود را وارد کنید.</option>
                        <?php foreach (LOCATION_TYPE as $key => $value) : ?>
                            <option value="<?= $key ?>"><?= $value ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="submit" name="btn" class="btn btn-primary input" value="ثبت">
            </form>
        </div>
    </div>


    <div id="filterLocModal" class="modall">
        <div class="modalMain" style="height: 400px;">
            <button id="filterModalClose" class="modalClose"><i class="fas fa-times clickable"></i></button>
            <form id="filterForm" action="<?= BASE_URL . 'process/ajaxHandler.php' ?>" method="POST">
                <div class="element">
                    <label for="locName">محدوده ی مد نظر شما (کیلومتر):</label>
                    <input id="locArea" type="number" name="area" class="form-control input" placeholder="برای مثال : 5 کیلو متر" aria-label="" aria-describedby="basic-addon1" autocomplete="off">
                </div>
                <div class="element">
                    <label for="filterCategory"> نوع مکان مد نظر شما: </label>
                    <select name="filterType" id="filterCategory" class="form-select input" aria-label="Default select example">
                        <option selected value="">نوع مکان مورد نظر خود را وارد کنید.</option>
                        <?php foreach (LOCATION_TYPE as $key => $value) : ?>
                            <option value="<?= $key ?>"><?= $value ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="submit" name="filterBtn" class="btn btn-primary input" value="ثبت">
            </form>

            <div class="resultFilterLoc"></div>

        </div>
    </div>



    <!-- user Profile -->
    <div class="profile">
        <i class="fas fa-times profileClose"></i>
        <div class="img">
            <img src="assets/img/PinClipart.com_earthquake-clipart_5260378.png" alt="Website Image">
            <p class="nameUser">سلام <?= $_SESSION['userLogin']['firstname']; ?> عزیز</p>
        </div>

        <div class="info">
            <p class="title">اطلاعات شما</p>
            <?php $time = explode(' ', $_SESSION['userLogin']['created_at']) ?>
            <p class="created_at"><span>زمان عضویت شما :</span> <?php $v = new Verta($time[1]);
                                                                echo $v->format('%d %B %Y') ?></p>
            <p class="email"><span>ایمیل شما :</span> <?= $_SESSION['userLogin']['email']; ?></p>
        </div>

        <div class="profileLocations">
            <p class="title">مکان هایی که شما ثبت کردید</p>
            <div class="listOfLocations">
                <?php if (!is_null($userLocationProfile)) {
                    foreach ($userLocationProfile as $value) {
                ?>
                        <a href="?loc=<?= $value['id'] ?>">
                            <div class="loc">
                                <span><?= $value['title'] ?></span>
                                <span><?= $value['status'] ? 'فعال' : 'درحال برسی' ?></span>
                            </div>
                        </a>
                    <?php
                    }
                } else { ?>
                    <div class="locationNotExist">شما مکانی ثبت نکرده اید.</div>
                <?php } ?>
            </div>

            <a href="?userLogout=1">
                <botton class="userLogout">خروج از حساب</botton>
            </a>
        </div>
    </div>

    <!-- user Profile -->

    <script src="assets/js/script.js"></script>



    <script>
        $(document).ready(function() {
            $("i.profileClose").click(function(e) {
                $("div.profile").fadeOut(1000);
            });
            $('i#userPanel').click(function(e) {
                $("div.profile").fadeIn(1000);
            });
        });

        //---------------------------------------Query String For Show add Location alert---------------------------------------
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET['notCompleted']) and !empty($_GET['notCompleted']) and $_GET['notCompleted'] == 'ok') {
        ?>
                alert("اطلاعات را درباره ی مکان مورد نظر خود کامل کنید.");
                setTimeout(function() {
                    location.replace('index.php');
                }, 500)
        <?php

            }
        }
        ?>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET['completed']) and !empty($_GET['completed']) and $_GET['completed'] == 'ok') {
        ?>
                alert("مکان مورد نظر شما ثبت شد و منتظر تایید ادمین میباشد  ، در صورت تایید ادمین مکان مورد نظر شما برای تمام افراد نمایش داده میشود.");
                setTimeout(function() {
                    location.replace('index.php');
                }, 500)
        <?php

            }
        }
        ?>
    </script>


    <script>
        <?php if (!is_null($singleLoc)) : ?>
            L.marker([<?= $singleLoc['lat'] ?>, <?= $singleLoc['lng'] ?>]).addTo(map).bindPopup("<b><?= $singleLoc['title'] ?></b><br /> <?= LOCATION_TYPE[$singleLoc['type']] ?>.");
            map.setView([<?= $singleLoc['lat'] ?>, <?= $singleLoc['lng'] ?>], 15);
        <?php endif; ?>

        $('#search').keyup(function(e) {
            var searchInput = $("#search").val();
            if (searchInput != '') {
                $.ajax({
                    type: "post",
                    url: "process/ajaxHandler.php",
                    data: {
                        action: 'searchLoc',
                        value: searchInput
                    },
                    success: function(response) {
                        $("div.locResult").slideDown().html(response);
                    }
                });
            } else {
                $("a#resultSearchLink").remove();
                $("div.locNotExist").remove();
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            <?php if (!is_null($veriFideLocations)) :
                foreach ($veriFideLocations as $value) :
            ?>
                    L.marker([<?= $value['lat'] ?>, <?= $value['lng'] ?>]).addTo(map).bindPopup("<b><?= $value['title'] ?></b><br /> <?= LOCATION_TYPE[$value['type']] ?>.");
            <?php endforeach;
            endif; ?>
        });
    </script>


</body>

</html>