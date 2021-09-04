<?php

$router->group("dividas");

$router->get("/", "Debt:index");
$router->get("/create", "Debt:create");
$router->get("/edit/{debtid}", "Debt:edit");
$router->post("/", "Debt:store");
$router->post("/update/{debtid}", "Debt:update");
$router->post("/delete/{debtid}", "Debt:destroy");