<?php

declare(strict_types=1);

CONST TABLE = 'users';

class UserDB {
    /**
     * Search database for user
     * @param $conn - connection to database
     * @param $user - user object
     */
    private static function isExists(User $user): bool {
        $conn = Database::connect();
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
    public static function verify(User $user): bool {
        $conn = Database::connect();
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
    public static function register(User $user): RegisterCase {
        if (UserDB::isExists($user)) {
            return RegisterCase::USER_EXISTS;
        }

        $conn = Database::connect();
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
     * Get all users
     * @param $conn - connection to database
     */
    public static function getAll(): array|false {
        $conn = Database::connect();
        $sql = "SELECT * FROM " . TABLE;

        if ($result = $conn->query($sql)) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);

            if (!$rows) {
                return false;
            }
            return $rows;
        }
    }

    /**
     * Print data of all users to json format
     * @param $conn - connection to database
     */
    public static function printAllJSON(): string|false {
        $conn = Database::connect();
        return json_encode(self::getAll($conn));
        }
    }

    /**
     * Get display name of currently logged user
     * @param $conn - connection to database
     */
    public static function getCurrentUserDisplayName(): string {
        $conn = Database::connect();
        $sql = "SELECT displayname FROM " . TABLE . " WHERE name = '" . $_SESSION['user'] . "'";

        if ($result = $conn->query($sql)) {
            $value = $result->fetch_row()[0];
            return $value;
        }
    }
}
