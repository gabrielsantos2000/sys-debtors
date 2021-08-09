<?php

use App\Controllers\Debt as DebtController;

$router->group("dividas");

$router->get("/", "Debt:index");
$router->get("/{debtid}", "Debt:findById");
$router->get("/create", "Debt:create");
$router->post("/", "Debt:store");
$router->put("/{debtid}", "Debt:edit");
$router->delete("/{debtid}", "Debt:destroy");