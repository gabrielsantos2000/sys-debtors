<?php

namespace App\Database;

abstract class Connection
{
    private $pdo;
    private $options;

    protected function __construct(array $options = [])
    {
        try {
            if(!empty($options)) {
                $this->options = $options;
        
                $this->pdo = new \PDO(
                    'mysql:host='.$this->options["server"].';
                    dbname='.$this->options["dbname"], 
                    $this->options["uid"], 
                    $this->options["pass"],
                    [\PDO::ATTR_PERSISTENT => true]
                );
                
                $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $this->pdo->exec("set names utf8");
            } else {
                throw new \Exception("Insufficient information to connect database.", $e->getCode());
            }
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }

    protected function conn()
    {
        return $this->pdo;
    }
}