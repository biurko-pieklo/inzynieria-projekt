<?php
ini_set("log_errors", 1);
ini_set("error_log", "/var/www/inzynieria-projekt/error.log");

spl_autoload_register(function($class_name) {
    require('./src/' . $class_name . '.php');
});

session_start();

require_once('./theme/parts/header.php');
require_once('./theme/parts/upload.php');
require_once('./theme/parts/filelist.php');
require_once('./theme/parts/userlist.php');
require_once('./theme/parts/userpanel.php');
require_once('./theme/parts/footer.php');
