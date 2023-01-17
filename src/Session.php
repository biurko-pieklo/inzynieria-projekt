<?php

declare(strict_types=1);

class Session {
    public static function isLogged() {
        if (isset($_SESSION['logged'])) {
            return $_SESSION['logged'];
        } else {
            return false;
        }
    }

    public static function getUser($conn) {
        $sql = "SELECT displayname FROM users WHERE name = '" . $_SESSION['user'] . "'";

        if ($result = $conn->query($sql)) {
            $value = $result->fetch_row()[0];
            return $value;
        }

        return null;
    }

    public static function login($conn): void {
        if (!isset($_POST['login']) || $_POST['login'] == '' || !isset($_POST['password']) || $_POST['password'] == '') {
            return;
        }

        $user = new User($_POST['login'], $_POST['password']);

        if ($user->verify($conn)) {
            $_SESSION['logged'] = true;
            $_SESSION['user'] = $_POST['login'];
        }
    }

    public static function register($conn): void {
        if (!isset($_POST['reg_login']) || $_POST['reg_login'] == '' || !isset($_POST['reg_password']) || $_POST['reg_password'] == '') {
            return;
        }

        $user = new User($_POST['reg_login'], $_POST['reg_password'], $_POST['reg_displayname']);

        $reg = $user->register($conn);

        switch ($reg) {
            case RegisterCase::USER_EXISTS:
                echo "Login '" . $_POST['reg_login'] . "' already taken. Please choose something else.";
                break;
            case RegisterCase::BAD_PASSWORD:
                echo "Your password is not strong enough (at least 8 characters, one letter, one digit and one special)";
                break;
            case RegisterCase::ERROR:
                echo "Sorry, someting went wrong";
                break;
            case RegisterCase::REGISTERED:
                echo "Thank you for registering! You can now log into the system.";
                break;
        }
    }

    public static function logout(): void {
        unset($_SESSION['logged']);
        unset($_SESSION['user']);
    }
}
