<?php

namespace App\Database;

use App\Database\Connection;

class Crud extends Connection
{
    /** @var object */
    private $conn;

    public function __construct($conn)
    {
        parent::__construct($conn);
        $this->conn = parent::conn();
    }

    public function insert(string $table, array $data) : ?bool
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
        $query = $this->conn->prepare($sql);

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
        $query = $this->conn->prepare($sql);

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

        $query = $this->conn->prepare($sql);

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
            return ($this->conn->query($sql)->fetchAll());
        } else {
            $query = $this->conn->prepare($sql);
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
        return $this->conn->lastInsertId();
    }
}