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

        span.activ {
            background: rgb(0, 153, 0);
            padding: 6px 20px;
            color: #fff;
            font-weight: bold;
            border-radius: 20px;
        }

        span.activ:hover {
            background-color: green;
            cursor: pointer;
        }

        span.unActiv {
            background: rgb(221, 0, 0);
            padding: 6px 20px;
            color: #fff;
            font-weight: bold;
            border-radius: 20px;
        }

        span.unActiv:hover {
            background: rgb(187, 0, 0);
            cursor: pointer;
        }

        span.icon {
            font-size: 22px;
            cursor: pointer;
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
            background-color: white;
            margin: 100px auto;
        }

        .closeIcon {
            font-size: 25px;
            position: relative;
            top: 10px;
            right: 15px;
            z-index: 99999;
            color: red;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1 class="titlePage">پنل <span>مدیریت</span></h1>
    <div class="container">
        <header id="header">
            <span class="exit"><a href="?logout=true">خروج</a></span>
            <div class="right">
                <a href="<?= BASE_URL ?>"><span class="home"><i class="fas fa-home"></i></span></a>
                <span class="active">فعال</span>
                <span class="unActive">غیر فعال</span>
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

            <?php foreach ($locations as $value) : ?>
                <tr>
                    <td class=name"><?= $value['title'] ?></td>
                    <?php $date = explode('-', explode(" ", $value['createdAt'])[0]); ?>
                    <td><?= gregorian_to_jalali($date[0], $date[1], $date[2], '/') . " در ساعت " . explode(" ", $value['createdAt'])[1] ?></td>
                    <td><?= $value['lat'] ?></td>
                    <td><?= $value['lng'] ?></td>
                    <td><span class="activ">فعال</span></td>
                    <td><span class="unActiv">غیر فعال</span></td>
                    <td><span class="icon"><i class="fas fa-eye"></i></span></td>
                </tr>  
            <?php endforeach; ?>

        </table>
    </div>


    <div id="modal" class="modal">
        <div id="map">
            <i class="fas fa-times closeIcon"></i>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        var map = L.map('map').setView([51.505, -0.09], 13);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(map);

        // L.marker([51.5, -0.09]).addTo(map)
        //     .bindPopup("<b>Hello world!</b><br />I am a popup.").openPopup();


        $(document).ready(function() {
            $("span.icon").click(function() {
                $(".modal").fadeIn(1000);
            });

            $("i.closeIcon").click(function() {
                $(".modal").fadeOut(1000);
            });

        });
    </script>
</body>

</html>