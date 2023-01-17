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
            echo '<a href="' . $dir . $file . '">' . $file . '</a><br>';
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
}