<?php

declare(strict_types=1);

class Utils {
    /**
     * Filter an array with is_file, as array_filter callback does not include path
     */
    private static function getFiles(string $dir = ''): array {
        $files = scandir($dir);
        $result = [];

        foreach ($files as $file) {
            if (is_file($dir . $file)) {
                $result[] = $file;
            }
        }

        return $result;
    }

    /**
     * Displays a list of files in given directory
     */
    public static function printFiles(string $dir) {
        $files = self::getFiles($dir);

        foreach($files as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION) ? pathinfo($file, PATHINFO_EXTENSION) : 'other';
            echo '<a class="file" data-type="' . $ext . '" href="' . $dir . $file . '">' . $file . '</a>';
        }
    }

    /**
     * Check if password is strong enough and return array of reasons why (or confirm it is strong enough)
     */
    public static function passCheck(string $password): bool {

        if (strlen($password) < 8) {
            return false;
        }

        if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
            return false;
        }

        if (!preg_match("/\W/", $password)) {
            return false;
        }

        return true;
    }

    /**
     * Download file with given path
     */
    public static function downloadFile(string $file): void {
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            readfile($file);
            exit;
        }
    }

    /**
     * Check if login and password for logging in were provided
     */
    public static function verifyLoginPOST(): bool {
        if (!isset($_POST['login']) || $_POST['login'] == '' || !isset($_POST['password']) || $_POST['password'] == '') {
            return false;
        } else {
            return true;
        }
    }


    /**
     * Check if login and password for registering were provided
     */
    public static function verifyRegisterPOST(): bool {
        if (!isset($_POST['reg_login']) || $_POST['reg_login'] == '' || !isset($_POST['reg_password']) || $_POST['reg_password'] == '') {
            return false;
        } else {
            return true;
        }
    }
}