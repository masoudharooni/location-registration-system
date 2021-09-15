<?php
function isLoggedIn()
{
    return isset($_SESSION['login']);
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
