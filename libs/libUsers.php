<?php
function isLoggedIn()
{
    return isset($_SESSION['login']);
}

function isUserLoggedIn()
{
    return isset($_SESSION['userLogin']);
}

function login(string $username, string $password): bool
{
    global $admins;
    if (
        array_key_exists($username, $admins) and
        password_verify($password, $admins[$username])
    ) {
        $_SESSION['login'] = true;
        return true;
    } else {
        return false;
    }
}

function logout()
{
    unset($_SESSION['login']);
    return true;
}

/**-----------------------------------------Password Validation-----------------------------------------*/
function isValidPass($password): bool
{
    if (strlen($password) <= 8) {
        return false;
    } elseif (!preg_match("#[0-9]+#", $password)) {
        return false;
    } elseif (!preg_match("#[A-Z]+#", $password)) {
        return false;
    } elseif (!preg_match("#[a-z]+#", $password)) {
        return false;
    }
    return true;
}

/**----------------------------------------------------------------------------Is Unique data---------------------------------------------------------------------------- */


function isThereEmail(string $email): bool
{
    global $conn;
    $sql = "SELECT COUNT(email) AS eamilCount FROM users WHERE email LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->bind_result($eamilCount);
    $stmt->execute();
    $stmt->fetch();
    if ($eamilCount > 0) {
        return true;
    }
    return false;
}

function equal($dataOne, $dataTwo): bool
{
    if ($dataOne === $dataTwo) {
        return true;
    }
    return false;
}

/**-----------------------------------------REGISTER FUNCTION-----------------------------------------*/

function userRegister($params): array
{
    global $conn;
    $password = $params['password'];
    if (!equal($params['email'], $params['emailConfirm'])) {
        $result['bool'] = false;
        $result['alert'] = "ایمیل و تایید آن یکی نیست ، مجددا تلاش کنید.";
        return $result;
    }

    if (!equal($password, $params['passwordConfirm'])) {
        $result['bool'] = false;
        $result['alert'] = "پسورد و تایید آن یکی نیست ، مجددا تلاش کنید.";
        return $result;
    }

    if (!isValidPass($password)) {
        $result['bool'] = false;
        $result['alert'] = "پسورد شما باید 8 کاراکتر و شامل یک عدد یک کاراکتر کوچک و یک کاراکتر بزرگ باشد!";
        return $result;
    }
    if (isThereEmail($params['email'])) {
        $result['bool'] = false;
        $result['alert'] = "این ایمیل قبلا ثبت شده است!";
        return $result;
    }
    // data Valid
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (firstname , lastname , email , password) VALUES (? , ? , ? , ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $params['firstname'], $params['lastname'], $params['email'], $passwordHash);
    if ($stmt->execute()) {
        $result['bool'] = true;
        $result['alert'] = "ثبت نام با موفقیت انجام شد ، لطفا وارد سایت شوید.";
        return $result;
    }
    $result['bool'] = false;
    $result['alert'] = "ثبت نام شما موفق نبود ، لطفا مجددا تلاش کنید.";
    return $result;
}



function getUserByEmail(string $email)
{
    global $conn;
    $sql = "SELECT id , firstname , lastname , email , password , created_at FROM users WHERE email LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->bind_result($id, $firstname, $lastname, $emailNow, $password, $created_at);
    $stmt->execute();
    $stmt->fetch();
    $result = [
        'id' => $id,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $emailNow,
        'password' => $password,
        'created_at' => $created_at
    ];
    return $result ?? null;
}


/**----------------------------------------------------------------------------Login function---------------------------------------------------------------------------- */



function userLogin(array $params): bool
{
    if (isThereEmail($params['email'])) {
        $user = getUserByEmail($params['email']);
        if (password_verify($params['password'], $user['password'])) {
            $_SESSION['userLogin'] = $user;
            return true;
        }
    }
    return false;
}


/**-----------------------------------------Send Code To User Email For Pass Recovery-----------------------------------------*/

function sendEmail(string $email)
{
    $subject = "بازیابی پسورد سایت MH | MAP";
    $code = rand(100000, 999999);
    $massage = "لطفا این کد را در قسمت مشخص شده در وبسایت ما وارد کنید.{$code}";
    if (mail($email, $subject, $massage)) {
        return $code;
    }
    return null;
}

/**-----------------------------------------Update Password Recovery-----------------------------------------*/

function updatePassword(string $email, string $password)
{
    global $conn;
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $sql = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $passwordHash, $email);
    if ($stmt->execute()) {
        return true;
    }
    return false;
}
