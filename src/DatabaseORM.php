<?php

declare(strict_types=1);

use \SimpleORM\Model;

CONST SERVER_ORM = 'localhost';
CONST USER_ORM = 'mateusz';
CONST PASS_ORM = 'Julka';
CONST DB_ORM = 'projekt';

class DatabaseORM extends Model {
    /**
     * Connect to database
     */
    public static function setup() {

        try {

            \SimpleORM\Model::config(array(
                'name' => DB_ORM,
                'user' => USER_ORM,
                'pass' => PASS_ORM,
                'host' => SERVER_ORM,
                'charset' => 'utf8'
            ));

        } catch (Exception $e) {

             die("Connection failed");

        }

    }

    protected static function getTableName() {
        return 'users';
    }
}
