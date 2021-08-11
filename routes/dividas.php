<?php

use App\Controllers\Debt as DebtController;

$router->group("dividas");

$router->get("/", "Debt:index");
$router->get("/create", "Debt:create");
$router->post("/", "Debt:store");
$router->delete("/{id}", "Debt:delete");
$router->get("/edit/{debtid}", "Debt:edit");
$router->post("/update/{debtid}", "Debt:update");
$router->delete("/{debtid}", "Debt:destroy");