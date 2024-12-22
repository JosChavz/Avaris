<?php

$private_end = strpos(__DIR__, '/src') + 1;
define('ROOT', substr(__DIR__, 0, $private_end));

require ROOT . "vendor/autoload.php";

$env = parse_ini_file(ROOT . "/src/.env"); 

$site_name = 'https://avaris.hozay.io/';

define("HTTP", ($_SERVER["SERVER_NAME"] == "localhost")
    ? "http://localhost"
    : $site_name
);

// Checks for error handling
if ($env['DEBUG']) {
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// This is meant for the classes being imported later
use classes\Bank;
use classes\Database;
use classes\Transaction;
use classes\Session;
//use interfaces\DatabaseTemplate;
//foreach(glob(ROOT . 'src/interfaces/*.php') as $file) {
//    require_once($file);
//}

require_once("classes/Database.php");

// require_once 'functions.php

// -> All classes in directory
foreach(glob(ROOT . 'src/classes/*.php') as $file) {
    require_once($file);
}

// Autoload class definitions
function my_autoload($class) {
    if(preg_match('/\A\w+\Z/', $class)) {
        include('classes/' . $class . '.php');
    }
}
spl_autoload_register('my_autoload');

$session = new Session();

?>
