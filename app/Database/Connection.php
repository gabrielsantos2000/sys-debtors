<?php

namespace App\Database;

class Connection
{
    protected $pdo;
    protected $options;

    public function __construct(array $options = [])
    {
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
    }

    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    public function commitTransaction()
    {
        $this->pdo->commit();
    }

    public function rollBackTransaction()
    {
        $this->pdo->rollBack();
    }

    public function checkTransaction()
    {
        if( $this->pdo->errorCode() != 0 ) {
            $this->rollBackTransaction();
            return false;
        }
        return true;
    }

    public function insert(string $table, array $data) : ?int
    {
        $keys = [];
        $values = [];
        $params = [];

        foreach($data as $key => $val)
        {
            $value = strtolower($val) == "null" && !is_numeric($values[$key]) ? null : $val;

            $keys[] = $key;
            $values[$key] = $value;
            $params[] = sprintf(':%s', $key);
        }

        $sql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $table, implode(', ', $keys), implode(', ', $params));
        $query = $this->pdo->prepare($sql);

        try {
            $query->execute($values);
            return true;
        } catch (\PDOException $e) {
            return new \PDOException($e->getMessage());
        }
    }

    public function update(string $table, array $values, array $identifiers) : ?bool
    {
        $set = null;
        $where = null;

        $temp = array_keys($values);
        $lastRecord = end($temp);

        foreach($values as $key => $val) {
            $set .= $key . " = :" . $key;

            if($values[$key] == "null" && !is_numeric($values[$key]))
                $values[$key] = null;

            if($lastRecord != $key)
                $set .= ", ";
        }

        $temp = array_keys($identifiers);
        $lastRecord = end($temp);

        foreach($identifiers as $key => $val) {
            $where .= $key . " = '". $val . "'";
            if($lastRecord != $key)
                $where .= " AND ";
        }

        $sql = "UPDATE " . $table . " SET " . $set . " WHERE " . $where;
        $query = $this->pdo->prepare($sql);

        try {
            $query->execute($values);
            return true;
        } catch (\PDOException $e) {
            return new \PDOException($e->getMessage());
        }
    }

    public function delete(string $table, array $identifiers) : ?bool
    {
        $sql = "DELETE FROM " . $table;
        $where = null;

        $temp = array_keys($identifiers);
        $lastRecord = end($temp);

        foreach($identifiers as $identifier => $val) {
            $where .= $key . " = '" . $val . "'";
            if($lastRecord != $key)
                $where .= "AND ";
        }

        $sql .= " WHERE " . $where;

        $query = $this->pdo->prepare($sql);

        try {
            $query->execute();
            return true;
        } catch (\PDOException $e) {
            return new \PDOException($e->getMessage());
        }
    }

    public function query($sql, $result = true) : ?array
    {
        if($result == true) {
            return ($this->pdo->query($sql)->fetchAll());
        } else {
            $query = $this->pdo->prepare($sql);
            try {
                $query->execute();
                return true;
            } catch (\PDOException $e) {
                return new \PDOException($e->getMessage());
            }
        }
    }

    public function lastId()
    {
        return $this->pdo->lastInsertId();
    }
}