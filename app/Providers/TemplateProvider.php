<?php

namespace App\Providers;

use \League\Plates\Engine;
use CoffeeCode\Router\Router;

class TemplateProvider
{
    /** @var string */
    private $engine;

    /** @var string */
    private $msg;

    /** @var string */
    private $typeMessage;

    /** @var instance */
    private $router;

    /**
     * Return a template.
     * @return TemplateProvider
     */

    public function __construct()
    {
        $this->router = new Router(BASE_URL);
    }

    public function view(string $template, string $file, array $data = []): TemplateProvider
    {
        $this->engine = new Engine(__DIR__.'/../../views/templates/'.$template.'/');

        if($this->msg != "") {
            $this->engine->addData(['msg' => $this->msg]);
        }

        echo $this->engine->render($file, $data);
        return $this;
    }

    /**
     * 
     * @param string $msg
     * @return string
     */
    public function message(string $typeMessage = "default", string $msg): TemplateProvider
    {
        $this->msg = $msg;
        $this->typeMessage = $typeMessage;
        return $this;
    }
}