<?php

require_once __DIR__ . '/vendor/autoload.php';

use CoffeeCode\Router\Router;
use App\Models\Debtor as DebtorModel;
use App\Database\Connection;

$router = new Router(BASE_URL);

/** Cntrollers */
$router->namespace("App\Controllers");

/** Default Route */
$router->group(null);
$router->get("/", "Debtor:dashboard");

$devedorModel = new DebtorModel(DB_CONFIG);
$allDebtors = $devedorModel->findAll();

/** Including routes */
$pathRoutes = __DIR__ . '/routes/';
$routes = opendir($pathRoutes);

while($dirRouteName = readdir($routes)) {
    if(($dirRouteName != "." && $dirRouteName != "..") && is_file($pathRoutes.$dirRouteName)) {
        include_once $pathRoutes.$dirRouteName;
    }
}