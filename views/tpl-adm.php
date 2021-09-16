<?php

use Hekmatinasser\Verta\Verta;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin Panel</title>
    <link href="assets/img/favicon.png" rel="shortcut icon" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--leaflet-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <style>
        a {
            text-decoration: none;
            color: inherit;
        }

        @font-face {
            font-family: sahelBlack;
            font-style: normal;
            font-weight: 300;
            src: url('assets/fonts/Sahel-black.woff') format('woff');
        }

        @font-face {
            font-family: sahel;
            font-style: normal;
            font-weight: 300;
            src: url('assets/fonts/Sahel-light.woff') format('woff');
        }

        body {
            background-color: #ddd;
            direction: rtl;
            font-family: sahel;
        }

        .container {
            background-color: #fff;
            width: 80%;
            margin: auto;
            /* height: 300px; */
            border-radius: 10px;
            position: relative;
        }

        * {
            box-sizing: border-box;
        }

        .titlePage {
            text-align: center;
            font-family: sahelBlack;
        }

        .titlePage span {
            color: rgb(0, 97, 207);
        }

        #header {
            padding: 15px;
            font-family: sahelBlack;
        }

        #header span {
            opacity: .7;
        }

        #header span:hover {
            opacity: 1;
            cursor: pointer;
        }

        #header .exit {
            padding: 5px 20px;
            display: inline-block;
            background-color: rgb(233, 233, 233);
            position: absolute;
            bottom: 15px;
            left: 10px;
            border-radius: 20px;
        }

        #header .home {
            font-size: 22px;
            margin: 0 15px;
            background-color: rgb(235, 235, 235);
            border-radius: 40px;
            padding: 3px 15px;
        }

        #header .active {
            margin: 0 0 0 15px;
            background-color: green;
            padding: 7px 15px;
            color: #fff;
            border-radius: 25px;
        }

        #header .unActive {
            background-color: rgb(238, 238, 238);
            padding: 7px 15px;
            border-radius: 25px;
            color: #555;
        }

        table {
            /* background-color: red; */
            width: 100%;
            text-align: center;
        }

        table td,
        table th {
            padding: 10px;
        }

        table tr:not(:last-child):nth-child(even) {
            background-color: rgb(246, 246, 246);
        }

        span.active {
            background: rgb(0, 153, 0);
            padding: 6px 22px;
            color: #fff;
            font-weight: bold;
            border-radius: 20px;
            float: right;
        }

        span.active:hover {
            background-color: green;
            cursor: pointer;
        }

        span.unActive {
            background: rgb(221, 0, 0);
            padding: 6px 10px;
            color: #fff;
            font-weight: bold;
            border-radius: 20px;
            float: right;
        }

        span.unActive:hover {
            background: rgb(187, 0, 0);
            cursor: pointer;
        }

        span.icon {
            font-size: 22px;
            cursor: pointer;
            float: left;
            margin-top: 2px;
        }

        span.icon:hover {
            color: grey;
        }

        table th {
            font-family: sahelBlack;
            font-size: 20px;
        }

        td.name {
            width: 39%;
        }

        .modal {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.445);
            display: none;
        }

        #map {
            width: 80%;
            height: 450px;
            margin: 100px auto;
            display: block;
            position: relative;
        }

        .closeIcon {
            font-size: 25px;
            position: absolute;
            top: 10px;
            right: 15px;
            z-index: 99999;
            color: red;
            cursor: pointer;
        }

        .notExist {
            text-align: center;
            font-family: 'sahelBlack';
            color: #3f51b5;
            background-color: #00ffe721;
            margin: auto;
            border-radius: 10px 10px 0 0;
            padding: 7px;
        }
    </style>
</head>

<body>
    <h1 class="titlePage">پنل <span>مدیریت</span></h1>
    <div class="container">
        <header id="header">
            <span class="exit"><a href="?logout=true">خروج</a></span>
            <div class="right">
                <span class="active"><a href="?active=1">فعال</a></span>
                <span class="unActive" style="margin-left: 10px;"><a href="?active=2">همه</a></span>
                <span class="unActive"><a href="?active=0">غیر فعال</a></span>
                <a href="<?= BASE_URL ?>"><span class="home"><i class="fas fa-home"></i></span></a>
            </div>
        </header>
    </div>

    <div class="container" style="margin-top: 30px;">
        <table>
            <tr>
                <th>عنوان مکان</th>
                <th>تاریخ ثبت</th>
                <th>طول جغرافیایی</th>
                <th>عرض جغرافیای</th>
                <th>وضعیت</th>
            </tr>

            <?php
            if (!is_null($locations)) {
                foreach ($locations as $value) : ?>
                    <tr>
                        <td class=name"><?= $value['title'] ?></td>
                        <?php $time = explode(' ', $value['createdAt']) ?>
                        <td><?php $v = new Verta($value['createdAt']);
                            echo $v->format('%d %B %Y') . "<br>" . "<span style='color:#ff0040; font-family:sahelBlack;margin-left:5px'>زمان:</span>" . $time[1]; ?></td>
                        <td><?= $value['lat'] ?></td>
                        <td><?= $value['lng'] ?></td>
                        <td>
                            <span id="status" data-id="<?= $value['id'] ?>" data-status="<?= ($value['status']) ? 0 : 1 ?>" class="<?= ($value['status'] ? "active" : "unActive") ?>"><?= ($value['status'] ? "فعال" : 'غیر فعال') ?></span>
                            <span data-id="<?= $value['id']; ?>" class="icon"><i class="fas fa-eye"></i></span>
                        </td>
                    </tr>
                <?php endforeach;
            } else { ?>

                <div class="notExist">هیچ لوکیشینی وجود ندارد.</div>
            <?php } ?>

        </table>
    </div>


    <div id="modal" class="modal">
        <div class="modal-averly" id="map">
            <i class="fas fa-times closeIcon"></i>
            <iframe style="width: 100%; height: 100%;" id="iframe">
            </iframe>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $("span.icon").click(function() {
                var id = $(this).attr("data-id");
                $(".modal").fadeIn(1000);
                $("#iframe").attr('src', "index.php?loc=" + id);
            });

            $("i.closeIcon").click(function() {
                $(".modal").fadeOut(1000);
            });


            $("span#status").click(function() {
                var status = $(this).attr("data-status");
                var id = $(this).attr("data-id");
                $.ajax({
                    type: "post",
                    url: "process/ajaxHandler.php",
                    data: {
                        action: 'activeLoc',
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            });




        });
    </script>
</body>

</html>