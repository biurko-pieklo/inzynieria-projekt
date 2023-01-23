<?php

declare(strict_types=1);

CONST TABLE = 'users';

class User {
    private string $login;
    private string $displayName;
    private string $password;

    function __construct(string $login, string $password, string $displayName = '') {
        $this->setLogin($login);
        $this->setPassword($password);
        $this->setDisplayName($displayName);
    }

    /**
     * Returns login of the user
     */
    public function getLogin(): string {
        return $this->login;
    }

    /**
     * Sets login of the user
     */
    public function setLogin(string $login): void {
        $this->login = $login;
    }

    /**
     * Returns display name of the user
     */
    public function getDisplayName(): string {
        return $this->displayName;
    }

    /**
     * Sets name of the user
     */
    public function setDisplayName(string $displayName = ''): void {
        $this->displayName = $displayName != '' ? $displayName : $this->getLogin();
    }

    /**
     * Returns password of the user
     */
    private function getPassword(): string {
        return $this->password;
    }

    /**
     * Sets name of the user
     */
    private function setPassword(string $password): void {
        $this->password = $password;
    }

    public function isExists($conn) {
        $sql = "SELECT * FROM " . TABLE . " WHERE name = '" . $this->getLogin() . "'";

        if ($result = $conn->query($sql)) {
            $row = $result->fetch_row();

            if (!$row) {
                return false;
            }

            return true;
        }

    }

    public function verify($conn) {
        $sql = "SELECT password FROM " . TABLE . " WHERE name = '" . $this->getLogin() . "'";

        if ($result = $conn->query($sql)) {
            $row = $result->fetch_row();

            if (!$row) {
                return false;
            }

            $value = $row[0];
        }

        return $this->password == $value;
    }

    public function register($conn): RegisterCase {
        if ($this->isExists($conn)) {
            return RegisterCase::USER_EXISTS;
        }

        $sql = "INSERT INTO " . TABLE . "(name, displayname, password) 
            VALUES ( '" . $this->getLogin() . "', '" . $this->getDisplayName() . "', '" . $this->getPassword() . "')";

        if (Utils::passCheck($this->getPassword())){
            if ($conn->query($sql) === TRUE) {
                return RegisterCase::REGISTERED;
            } else {
                return RegisterCase::ERROR;
            }
        } 

        return RegisterCase::BAD_PASSWORD;
    }

    public static function printAllJSON($conn) {
        $sql = "SELECT * FROM " . TABLE;

        if ($result = $conn->query($sql)) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);

            if (!$rows) {
                return;
            }
            return json_encode($rows);
        }
    }
}
