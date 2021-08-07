<?php

require_once __DIR__ . '/vendor/autoload.php';

use CoffeeCode\Router\Router;
use App\Models\Devedor as DevedorModel;
use App\Controllers\Devedor as DevedorController;

$devedorController = new DevedorController();
// $devedorController->home();

$db = new App\Database\Connection(DB_CONFIG);

$devedorModel = new DevedorModel($db);
/**teste insert devedor */
// $storeDevedor = $devedorModel->store([
//     "nm_devedor" => "Gabriel",
//     "dt_nascimento" => "2000-07-01",
//     "nr_cpf_cnpj" => "46628986845",
//     "ic_ativo" => 1,
//     "created_at" => date("Y-m-d H:i:s"),
//     "updated_at" => null
// ]);
// if($storeDevedor) 
//     echo "Devedor cadastrado com sucesso!";
// else
//     echo "Falha ao cadastrar novo devedor.";

// $fetchAllDevedores = $devedorModel->index();
// var_dump($fetchAllDevedores);

// $fetchById = $devedorModel->findById(1);
// var_dump($fetchById);

$update = $devedorModel->update(1, ["dt_nascimento" => "2000-07-02"]);
var_dump($update);

$router = new Router(BASE_URL);

$router->namespace("App\Controllers");

$router->group(null);
$router->get("/", "Devedor:home");

$router->dispatch("");

/**
 * ERROS
 */
$router->group("ooops");
$router->get("/{errcode}", "Devedor:error");
$router->get("/{filter}", "Devedor:home");

if($router->error()){
    $router->redirect("/ooops/{$router->error()}");
}

