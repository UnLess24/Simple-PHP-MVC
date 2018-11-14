<?php

namespace App;

use App\Controllers\Controller;
use App\Kernel\Request;
use App\Kernel\Route;

$requestRoute = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestQuery = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'POST') {
    $requestQuery = $_POST;
} else if ($requestMethod === 'PUT') {
    $requestQuery = file_get_contents("php://input");
}

$requestData = new Request($requestQuery);

Controller::invoke(Route::getRoute($requestMethod, $requestRoute), $requestData);

