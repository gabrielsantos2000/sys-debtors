<?php

namespace App\Providers;

use \League\Plates\Engine;

class TemplateProvider
{
    /** @var string */
    private $template;

    /** @var string */
    private $msg;

    /**
     * Return a template.
     * @return TemplateProvider
     */
    public function view(string $template, string $file, array $data = []): TemplateProvider
    {
        $this->template = $this->template = new Engine(__DIR__.'/../../views/templates/'.$template.'/');

        if($this->msg != "") {
            $this->template->addData(['msg' => $this->msg]);
        }

        echo $this->template->render($file, $data);
        return $this;
    }

    /**
     * 
     * @param string $msg
     * @return string
     */
    public function message($msg): TemplateProvider
    {
        $this->msg = $msg;
        return $this;
    }
}