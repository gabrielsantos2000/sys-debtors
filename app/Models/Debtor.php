<?php

namespace App\Models;

use App\Database\Crud;

class Debtor
{
    /** @var instance */
    private $crud;

    /** @var string */
    private $table = "tb_devedor";
    
    public function __construct($dbConfig)
    {
        $this->crud = new Crud(DB_CONFIG);
    }

    /**
     * Return a list of debtors.
     * 
     * @return array 
     */
    public function findAll() : array
    {
        try {
            return ($this->crud->query("SELECT * FROM {$this->table} WHERE ic_ativo = 1"));
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
            $debtor = $this->crud->query("SELECT * FROM {$this->table} WHERE id = {$debtorId}");

            return count($debtor) > 0 ? $debtor : [];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Save a new debtor
     * 
     * @param array $data : array with debtor data.
     * @return bool
     */
    public function insert(array $data) : bool
    {
        try {
            if($this->crud->insert($this->table, $data))
                return true;
            return false;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Update an existing debtor.
     * 
     * @param int $debtorId
     * @param array $data : array with debtor data to update.
     * @return bool
     */
    public function update(int $debtorId, array $data) : bool
    {
        try {
            if($this->crud->update($this->table, $data, ["id" => $debtorId]))
                return true;
            return false;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Delete a existing debtor
     * @param int $debtorId
     */
    public function delete(int $debtorId) : bool
    {
        try {
            if($this->crud->delete($this->table, ["id" => $debtorId]));
                return true;
            return false;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Checks if there is cpf or cnpj registered in the system.
     * 
     * @return bool
     */
    public function findByCpfOrCnpj(string $cpfOrCnpj) : bool
    {
        try {
            $isRegistred = $this->crud->query("SELECT * FROM {$this->table} WHERE nr_cpf_cnpj = {$cpfOrCnpj}");

            return count($isRegistred) > 0 ? true : false;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}