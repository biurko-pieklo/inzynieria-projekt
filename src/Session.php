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

    public static function logout(): void {
        unset($_SESSION['logged']);
        unset($_SESSION['user']);
    }
}
