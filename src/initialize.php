<?php
use classes\Database;
use classes\Session;

$private_end = strpos(__DIR__, '/src') + 1;
define('ROOT', substr(__DIR__, 0, $private_end));

require ROOT . "vendor/autoload.php";

$env = parse_ini_file(ROOT . "/.env");

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

global $env;
$database = new mysqli($env['DB_HOST'], $env['DB_USER'], $env['DB_PASSWORD'], $env['DB_NAME']);
Database::set_database($database);

require_once 'functions.php';

$session = new Session();

// TEMPLATES
define("TEMPLATE_OUTER", ROOT . '/src/templates/template.php');
define("TEMPLATE_DASHBOARD", ROOT . '/src/templates/dashboard-template.php');
