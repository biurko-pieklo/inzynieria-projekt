<?php

declare(strict_types=1);

CONST TABLE = 'users';

class UserDB {
    /**
     * Search database for user
     * @param $conn - connection to database
     * @param $user - user object
     */
    private static function isExists(mysqli $conn, User $user) {
        $sql = "SELECT * FROM " . TABLE . " WHERE name = '" . $user->getLogin() . "'";

        if ($result = $conn->query($sql)) {
            $row = $result->fetch_row();

            if (!$row) {
                return false;
            }

            return true;
        }
    }

    /**
     * Verify password
     * @param $conn - connection to database
     * @param $user - user object
     */
    public static function verify(mysqli $conn, User $user) {
        $sql = "SELECT password FROM " . TABLE . " WHERE name = '" . $user->getLogin() . "'";

        if ($result = $conn->query($sql)) {
            $row = $result->fetch_row();

            if (!$row) {
                return false;
            }

            $value = $row[0];
        }

        return $user->getPassword() == $value;
    }

    /**
     * Register new user
     * @param $conn - connection to database
     * @param $user - user object
     */
    public static function register(mysqli $conn, User $user): RegisterCase {
        if (UserDB::isExists($conn, $user)) {
            return RegisterCase::USER_EXISTS;
        }

        $sql = "INSERT INTO " . TABLE . "(name, displayname, password) 
            VALUES ( '" . $user->getLogin() . "', '" . $user->getDisplayName() . "', '" . $user->getPassword() . "')";

        if (Utils::passCheck($user->getPassword())){
            if ($conn->query($sql) === TRUE) {
                return RegisterCase::REGISTERED;
            } else {
                return RegisterCase::ERROR;
            }
        } 

        return RegisterCase::BAD_PASSWORD;
    }

    /**
     * Print data of all users to json format
     * @param $conn - connection to database
     */
    public static function printAllJSON(mysqli $conn) {
        $sql = "SELECT * FROM " . TABLE;

        if ($result = $conn->query($sql)) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);

            if (!$rows) {
                return;
            }
            return json_encode($rows);
        }
    }

    /**
     * Get display name of currently logged user
     * @param $conn - connection to database
     */
    public static function getCurrentUserDisplayName(mysqli $conn): string {
        $sql = "SELECT displayname FROM " . TABLE . " WHERE name = '" . $_SESSION['user'] . "'";

        if ($result = $conn->query($sql)) {
            $value = $result->fetch_row()[0];
            return $value;
        }
    }
}
