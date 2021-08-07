<?php

namespace App\Models;

use App\Database\Connection;

class Devedor
{
    /** @var object */
    private $conn;
    /** @var string */
    private $table = "tb_devedor";
    
    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Return a list of debtors.
     * 
     * @return array 
     */
    public function index() : array
    {
        return ($this->conn->query("SELECT * FROM {$this->table} WHERE ic_ativo = 1"));
    }

    /**
     * Save a new debtor
     * 
     * @param array $data : array with debtor data.
     * @return bool
     */
    public function store(array $data) : bool
    {
        try {
            if($this->conn->insert($this->table, $data))
                return true;
            return false;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Update an existing debtor.
     * 
     * @param int $debtorId : debtor id.
     * @param array $data : array with debtor data to update.
     * @return bool
     */
    public function update(int $debtorId, array $data) : bool
    {
        try {
            if($this->conn->update($this->table, $data, ["id" => $debtorId]))
                return true;
            return false;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Find a debtor by id.
     * 
     * @param int $debtorId : debtor id.
     */
    public function findById(int $debtorId) : array
    {
        try {
            $debtor = $this->conn->query("SELECT * FROM {$this->table} WHERE id = {$debtorId}");

            return count($debtor) > 0 ? $debtor : [];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}