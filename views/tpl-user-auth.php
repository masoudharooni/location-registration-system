<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Auth Form</title>
    <link href="assets/img/favicon.png" rel="shortcut icon" type="image/png">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css'>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/auth.css">
    <style>
        .resultَAuth {
            /* padding: 10px; */
            text-align: center;
            background: #26a69a;
            color: #fff;
            font-weight: bold;
            font-size: 18px;
            font-family: 'sahelBlack';
        }
    </style>
</head>

<body>
    <div class="container white z-depth-2">
        <ul class="tabs teal">
            <li class="tab col s3"><a class="white-text active" href="#login">login</a></li>
            <li class="tab col s3"><a class="white-text" href="#register">register</a></li>
        </ul>
        <div id="login" class="col s12">
            <!-- login form -->
            <form class="col s12" id="loginForm" action="<?= BASE_URL ?>process/ajaxHandler.php" method="POST">
                <div class="form-container">
                    <h3 class="teal-text">Hello</h3>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="email" type="email" class="validate" name="email" required>
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="password" type="password" class="validate" name="password" required>
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <br>
                    <button class="btn waves-effect waves-light teal" type="submit" name="loginBtn">Login</button>
                    <br>
                    <br>
                    <span id="forgetPassBtn" style="cursor: pointer;">Forgotten password?</span>
                </div>
            </form>
        </div>
        <div id="register" class="col s12">
            <!-- register form -->
            <form class="col s12" id="registerForm" action="<?= BASE_URL ?>process/ajaxHandler.php" method="POST">
                <div class="form-container">
                    <h3 class="teal-text">Welcome</h3>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="last_name" type="text" class="validate" name="firstname" required>
                            <label for="last_name">First Name</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="last_name" type="text" class="validate" name="lastname" required>
                            <label for="last_name">Last Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="email" type="email" class="validate" name="email" required>
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="email-confirm" type="email" class="validate" name="emailConfirm" required>
                            <label for="email-confirm">Email Confirmation</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="password" type="password" class="validate" name="password" required>
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="password-confirm" type="password" class="validate" name="passwordConfirm" required>
                            <label for="password-confirm">Password Confirmation</label>
                        </div>
                    </div>

                    <button class="btn waves-effect waves-light teal" type="submit" name="registerBtn">Register</button>

                </div>
            </form>
        </div>
        <div id="resultAuth" class="resultَAuth"></div>
    </div>
    <!-- partial -->
    <script src='https://code.jquery.com/jquery-2.1.1.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js'></script>


    <!-- modal for forget password -->
    <div class="modal-content">
        <i id="closeIconPassRecovery" class="fas fa-times"></i>

        <form id="passRecovery" action="<?= BASE_URL ?>process/ajaxHandler.php" method="POST">
            <input name="email" type="email" class="input inputRecovery" placeholder="ایمیل خود را وارد کنید." required>
            <input name="password" type="password" class="input inputRecovery" placeholder="رمز عبور جدید خود را وارد کنید." required>
            <input type="submit" class="btn btnRecover" value="ارسال ایمیل">
        </form>
        <input id="codeInput" type="number" class="input inputRecovery" style="text-align: right; width: 88%; display: block; margin: 30px auto; font-family: sahelBlack;" placeholder="کد شش رقمی که برای شما ایمیل شده است را وارد کنید." required>
        <botton id="codeBtn" type="submit" class="btn btnRecover" style="width: 88%; display: block; margin: 20px auto;">تایید کد</botton>
        <div class="resultRecover"></div>
    </div>


    <!-- Ajax code for register -->
    <script>
        $(document).ready(function() {
            $("form#registerForm").submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var editserialize = form.serialize();
                editserialize = decodeURIComponent(editserialize.replace(/%2F/g, " "));

                $.ajax({
                    type: "post",
                    url: form.attr('action'),
                    data: {
                        action: 'userRegister',
                        data: editserialize
                    },
                    success: function(response) {
                        $('div#resultAuth').html(response).css({
                            padding: '10px'
                        });
                    }
                });
            });


            $("form#loginForm").submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var editserialize = form.serialize();
                editserialize = decodeURIComponent(editserialize.replace(/%2F/g, " "));
                $.ajax({
                    type: "post",
                    url: form.attr('action'),
                    data: {
                        action: 'userLogin',
                        data: editserialize
                    },
                    success: function(response) {
                        if (response == 1) {
                            window.location.href = "http://localhost/map/";
                        } else {
                            $('div#resultAuth').html(response).css({
                                padding: '10px'
                            });
                        }
                    }
                });
            });


            $("form#passRecovery").submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var editserialize = form.serialize();
                editserialize = decodeURIComponent(editserialize.replace(/%2F/g, " "));
                var result = $('div.resultRecover');
                $.ajax({
                    type: "post",
                    url: form.attr('action'),
                    data: {
                        action: 'passRecover',
                        data: editserialize
                    },
                    success: function(response) {
                        result.html(response);
                        // alert(response);
                    }
                });
            });

            $('#codeBtn').click(function(e) {
                var code = $('input#codeInput').val();
                var result = $('div.resultRecover');
                $.ajax({
                    type: "post",
                    url: "<?= BASE_URL ?>process/ajaxHandler.php",
                    data: {
                        action: 'passRecover',
                        code: code
                    },
                    success: function(response) {
                        result.html(response);
                        // alert(response);
                    }
                });
                // alert('ok');
            });

        });

        $('i#closeIconPassRecovery').click(function() {
            $('div.modal-content').fadeOut(1000);
        });
        $('#forgetPassBtn').click(function(e) {
            $('div.modal-content').fadeIn(1000);
        });
    </script>

</body>

</html>