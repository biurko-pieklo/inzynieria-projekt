<?php

declare(strict_types=1);

CONST SERVER = 'localhost';
CONST USER = 'mateusz';
CONST PASS = 'Julka';
CONST DB = 'projekt';

class Database {
    public static function connect() {

        try {

            $conn = new mysqli(SERVER, USER, PASS, DB);

        } catch (Exception $e) {

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

        }

        return $conn;
    }
}
