<?php

namespace App\Ajax;

require_once "../../vendor/autoload.php";

class AjaxTransaction 
{
    /** @var string */
    private $model;

    /** @var string */
    private $method;

    /** @var array */
    private $params;

    /** @var string */
    private $handler;

    public function __construct(string $model, string $method, array $params)
    {
        $this->model = $model;
        $this->method = $method;
        $this->params = $params;
        $this->handler = "App\Models\\";
    }

    /**
     * 
     * @return array
     */
    public function execute(): ?array
    {
        $respose = [];

        $this->model = $this->handler.$this->model;
        if (class_exists($this->model)) {
            $model = $this->model;
            $newModel = new $model();
            if (method_exists($model, $this->method)) {
                $response = call_user_func_array([$newModel, $this->method], $this->params);
                return $response;
            }
            return null;
        }
    }
}

if(isset($_GET['model'], $_GET['method'])) {
    $model = $_GET['model'];
    $method = $_GET['method'];
    $params[] = isset($_GET['params']) ? $_GET['params'] : [];

    $ajaxTransaction = new AjaxTransaction($model, $method, $params);
    $response = $ajaxTransaction->execute();
    
    if(!empty($response)) {
        die(json_encode($response));
    }
    
}

die(json_encode(["st" => 0]));
