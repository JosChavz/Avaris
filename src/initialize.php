<?php
use classes\Database;
use classes\Session;

$private_end = strpos(__DIR__, '/src') + 1;
define('ROOT', substr(__DIR__, 0, $private_end));

require ROOT . "vendor/autoload.php";

if (file_exists(ROOT . "/.env")) {
    $env = parse_ini_file(ROOT . "/.env");
} else {
    $env = [
        'DB_HOST'     => getenv('DB_HOST'),
        'DB_USER'     => getenv('DB_USER'),
        'DB_PASSWORD' => getenv('DB_PASSWORD'),
        'DB_NAME'     => getenv('DB_NAME'),
        'DEBUG'       => getenv('DEBUG') ?: false,
    ];
}

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

/* check connection */
if ($database->connect_errno) {
    printf("Connect failed: %s\n", $database->connect_error);
    exit();
}

require_once 'functions.php';

$session = new Session();

// TEMPLATES
define("TEMPLATE_OUTER", ROOT . '/src/templates/template.php');
define("TEMPLATE_DASHBOARD", ROOT . '/src/templates/dashboard-template.php');
