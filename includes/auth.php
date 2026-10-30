<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function app_path(string $file): string
{
    $inAdmin =
        basename(dirname($_SERVER['SCRIPT_FILENAME']))
        === 'admin';

    return ($inAdmin ? '../' : '') . $file;
}

function require_login(): void
{
    if (!isset($_SESSION['user_id'])) {

        $_SESSION['login_error']
            = '続けるにはログインが必要です';

        header(
            'Location: ' .
            app_path('login.php')
        );

        exit;
    }
}

function require_admin(): void
{
    require_login();

    if (($_SESSION['role'] ?? '') !== 'admin') {

        header(
            'Location: ' .
            app_path('forbidden.php')
        );

        exit;
    }
}