<?php

namespace App\Controllers;

class Devedor
{
    public function home()
    {
        echo "Hello World";
    }

    public function error($data)
    {
        echo "Error {$data['errcode']}";
    }
}