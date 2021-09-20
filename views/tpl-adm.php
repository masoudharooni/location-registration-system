<?php

use Hekmatinasser\Verta\Verta;

use function PHPSTORM_META\type;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin Panel</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link href="assets/img/favicon.png" rel="shortcut icon" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> -->


    <style>
        .modal-edit {
            width: 50%;
            height: 350px;
            background-color: #000000b5;
            position: absolute;
            top: 25%;
            right: 25%;
            border-radius: 20px;
            padding: 40px;
            display: none;
        }

        input.editInput {
            display: block;
            margin: auto;
            width: 80%;
            box-sizing: border-box;
            padding: 7px 10px;
            font-family: 'sahelBlack';
            border-radius: 10px;
            outline: none;
        }

        label {
            display: block;
            width: 80%;
            margin: auto;
            color: #fff;
            font-family: 'sahelBlack';
            padding: 12px 7px;
        }

        select.editType {
            display: block !important;
            width: 80% !important;
            margin: auto !important;
        }

        input.editSubmit {
            display: block;
            width: 80%;
            margin: 30px auto;
            padding: 10px;
            font-family: 'sahelBlack';
            border-radius: 10px;
            background-color: rgb(0 97 207);
            color: #fff;
            border: none;
            font-size: 18px;
            cursor: pointer;
            text-align: center;

        }

        input.editSubmit:hover {
            background-color: rgb(0 97 170);
        }
    </style>

</head>

<body>
    <h1 class="titlePage">پنل <span>مدیریت</span></h1>

    <div class="container">
        <header id="header">
            <span class="exit" onclick="return confirm('مطمئـــــــــــــــن هستید برای خروج؟');"><a href="?logout=true">خروج</a></span>
            <div class="right">
                <span class="home" onclick="return confirm('مطمئن هستیـــــد که میخواهید به صفحه ی اصلــــــــــــــی منتقل شوید؟');" style="float: right;margin-right: 0;"><a href="<?= BASE_URL ?>"><i class="fas fa-home"></i></a></span>
                <span class="active"><a href="?active=1">فعال</a></span>
                <span class="unActive" style="margin-left: 10px;"><a href="?active=2">همه</a></span>
                <span class="unActive"><a href="?active=0">غیر فعال</a></span>
                <span class="unActive" style="margin:0 10px ;"><a href="?sort=1">قدیمی ترین </a></span>
                <span class="unActive"><a href="?sort=0">جدید ترین </a></span>
                <select style="margin-right: 10px;" onchange="location = this.value;" name="type" id="category" class="form-select input" aria-label="Default select example">
                    <option selected value="adm.php">نوع مکان مورد نظر خود را وارد کنید.</option>
                    <?php foreach (LOCATION_TYPE as $key => $value) : ?>
                        <option class="locationType" value="adm.php?type=<?= $key ?>"><?= $value ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </header>
    </div>


    <div class="container" style="margin-top: 30px;">
        <table>
            <tr>
                <th>عنوان مکان</th>
                <th>تاریخ ثبت</th>
                <th>نوع مکان</th>
                <th>ایمیل کاربر</th>
                <th>وضعیت</th>
                <th></th>
            </tr>

            <?php
            if (!is_null($locations)) {
                foreach ($locations as $value) : ?>
                    <tr>
                        <td class=name"><?= $value['title'] ?></td>
                        <?php $time = explode(' ', $value['createdAt']) ?>
                        <td><?php $v = new Verta($value['createdAt']);
                            echo $v->format('%d %B %Y') . "<br>" . "<span style='color:#ff0040; font-family:sahelBlack;margin-left:5px'>زمان:</span>" . $time[1]; ?></td>
                        <td><?= LOCATION_TYPE[$value['type']] ?></td>
                        
                        <td>
                            <?php
                            $userInfo = getUserById($value['userId']);
                            echo $userInfo['email'];
                            ?>
                        </td>

                        <td>
                            <span style="float: none;" id="status" data-id="<?= $value['id'] ?>" data-status="<?= ($value['status']) ? 0 : 1 ?>" class="<?= ($value['status'] ? "active" : "unActive") ?>"><?= ($value['status'] ? "فعال" : 'غیر فعال') ?></span>
                            <!-- <span data-id="<?= $value['id']; ?>" class="icon"><i class="fas fa-eye"></i></span> -->
                        </td>

                        <td>
                            <a style="vertical-align: -6px;" onclick="return confirm('مطمئـــــــــــــــــــــــن هستید از حذف  <?= $value['title'] ?>؟')" href="?delete=<?= $value['id'] ?>"><i class="far fa-trash-alt"></i></a>
                            <span data-id="<?= $value['id']; ?>" class="icon"><i class="fas fa-eye"></i></span>
                            <i id="editIcon" data-id="<?= $value['id'] ?>" data-typeId="<?= $value['type'] ?>" data-typeTitle="<?= LOCATION_TYPE[$value['type']] ?>" data-name="<?= $value['title'] ?>" class="fas fa-edit editIcon" style="color: green;font-size: 20px;cursor: pointer;vertical-align: -6px; margin-right: 7px;margin-left: -7px;"></i>
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

    <!-- modal for edit location -->
    <div class="modal-edit">
        <i class="fas fa-times closeIcon" style="position: absolute;top: 20px;right: 20px;"></i>
        <form id="editLocationForm" action="process/ajaxHandler.php" method="POST">
            <label for="editInput">نام جدید را برای این مکان وارد کنید:</label>
            <input id="editInput" class="editInput" type="text" name="editName" placeholder="نام مکان را برای بروزرسانی وارد کنید...">

            <label for="typeInput" style="margin-top: 20px;">نوع مکان را در صورت نیاز تغیر دهید:</label>
            <select style="margin-right: 10px;" name="editType" id="category" class="form-select input editType" aria-label="Default select example">
                <option id="selectedOption" selected>نوع مکان</option>
                <?php foreach (LOCATION_TYPE as $key => $value) : ?>
                    <option class="locationType" value="<?= $key ?>"><?= $value ?></option>
                <?php endforeach; ?>
            </select>

            <input onclick="return confirm('از تغیـــــــــــــر اطلاعات اطمینان دارید؟')" type="submit" class="editSubmit" value="ثبت اطلاعات">
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>

    <script src="assets/js/adm.js"></script>



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