<?php

namespace App\Providers;

use \League\Plates\Engine;

class TemplateProvider
{
    /** @var string */
    private $engine;

    /** @var string */
    private $msg;

    /** @var string */
    private $typeMessage;

    /**
     * Return a template.
     * @return TemplateProvider
     */

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