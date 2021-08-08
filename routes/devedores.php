<?php

use App\Controllers\Debtor as DebtorController;

$debtor = new DebtorController(DB_CONFIG, $router);

$router->group("devedores");

$router->get("/", "Debtor:index");
$router->get("/{debtorid}", "Debtor:findById");
$router->get("/create", "Debtor:create");
$router->post("/", "Debtor:store");
$router->put("/{debtorid}", "Debtor:edit");
$router->delete("/{debtorid}", "Debtor:destroy");

$router->dispatch();

$router->group("ops");

if($router->error()){
    $router->redirect("/ops/{$router->error()}");
}