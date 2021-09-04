<?php

$router->group("devedores");

$router->get("/", "Debtor:index");
$router->get("/create", "Debtor:create");
$router->post("/", "Debtor:store");
$router->get("/edit/{debtorid}", "Debtor:edit");
$router->post("/delete/{id}", "Debt:delete");
$router->post("/update/{debtorid}", "Debtor:update");
$router->post("/delete/{debtorid}", "Debtor:destroy");