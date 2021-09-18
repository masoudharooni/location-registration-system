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
            <i id="satellite" titles="برای تغیر به حالت ماهواره ای ، کلیک کنید!" class="fas fa-globe clickable satellite titleAtr"></i>
            <i id="filterBtn" titles="برای فیلتر کردن نتایج کلیک کنید." class="fas fa-sort-amount-down-alt clickable satellite titleAtr"></i>
            <i id="defaultMap" titles="برای غیر به حالت اولیه کلیک کنید!" class="fas fa-map-marked-alt clickable satellite titleAtr"></i>
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

            <div class="resultFilterLoc">
                <!-- <div class="resultFilterElement">
                    <span>دانشگاه علمی کاربری اصفهان</span>
                    <span>فاصله :51555 KM</span>
                </div> -->
            </div>

        </div>
    </div>

    <script src="assets/js/script.js"></script>



    <script>
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