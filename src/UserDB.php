<?php

declare(strict_types=1);

CONST TABLE = 'users';
CONST ADMIN_ID = 1;

class UserDB {
    /**
     * Search database for user
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
     * @param $user - user object
     */
    public static function register(User $user): RegisterCase {
        if (self::isExists($user)) {
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
     * Remove user
     * @param $id - id of user to be removed
     */
    public static function remove(int $id): bool {
        if (self::isAdmin($id)) {
            return false;
        }

        $conn = Database::connect();
        $sql = "DELETE FROM " . TABLE . " WHERE id=" . $id;

        if ($conn->query($sql)) {
            return true;
        }

        return false;
    }

    /**
     * Get all users
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
     */
    public static function printAllJSON(): string|false {
        $conn = Database::connect();
        return json_encode(self::getAll($conn));
    }

    /**
     * Register users based on json format
     */
    public static function registerFromJSON($json): void {
        $conn = Database::connect();
        $decoded = json_decode($json, true);
        foreach ($decoded as $maybe_user) {
            try {
                $user = new User($maybe_user['name'], $maybe_user['password'], $maybe_user['displayname']);
                $user->register();
            } catch (Exception $e) {
                error_log("User registration from JSON file failed");
            }
        }
    }

    /**
     * Get display name of currently logged user
     */
    public static function getCurrentUserDisplayName(): string {
        $conn = Database::connect();
        $sql = "SELECT displayname FROM " . TABLE . " WHERE name = '" . $_SESSION['user'] . "'";

        if ($result = $conn->query($sql)) {
            $value = $result->fetch_row()[0];
            return $value;
        }
    }

    /**
     * Check if id belongs to admin
     */
    public static function isAdmin(int $id): bool {
        return $id == ADMIN_ID;
    }

    /**
     * Check if current user is admin
     */
    public static function isCurrentUserAdmin(): bool {
        $conn = Database::connect();
        $sql = "SELECT id FROM " . TABLE . " WHERE name = '" . $_SESSION['user'] . "'";

        if ($result = $conn->query($sql)) {
            $value = $result->fetch_row()[0];
            return $value == ADMIN_ID;
        }
    }
}
