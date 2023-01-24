<?php

declare(strict_types=1);

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
     * @param $login - user login
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
     * @param $displayName - user display name
     */
    public function setDisplayName(string $displayName = ''): void {
        $this->displayName = $displayName != '' ? $displayName : $this->getLogin();
    }

    /**
     * Returns password of the user
     */
    public function getPassword(): string {
        return $this->password;
    }

    /**
     * Sets name of the user
     * @param $password - user password
     */
    private function setPassword(string $password): void {
        $this->password = $password;
    }

    /**
     * Register a new user
     */
    public function register(): void {
        $reg = UserDB::register($this);

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

    /**
     * Log the user in
     */
    public function login(): void {
        if (UserDB::verify($this)) {
            $_SESSION['logged'] = true;
            $_SESSION['user'] = $_POST['login'];
            header('Location: .');
        }
    }

    /**
     * Log the user out
     */
    public static function logout(): void {
        unset($_SESSION['logged']);
        unset($_SESSION['user']);
    }

    /**
     * Print table of user data
     */
    public static function printAll(): void {
        $data = UserDB::getAll();
        if ($data) {
            echo '<table><tr><th>ID</th><th>Login</th><th>Display name</th></tr>';
            foreach ($data as $row) {
                echo '<tr><td>' . $row['id'] . '</td><td>' . $row['name'] . '</td><td>' . $row['displayname'] . '</td></tr>';
            }
        }
        echo '</table>';
    }
}
