<?php

namespace App\Models;

class Debt
{
    /** @var instance */
    private $crud;

    /** @var string */
    private $table = "tb_divida";
    
    /** @var string */
    private $table_item_divida_devedor = "tb_item_divida_devedor";

    /** @var string */
    private $table_devedor = "tb_devedor";

    public function __construct($dbConfig)
    {
        $this->crud = new Crud($dbConfig);
    }

    /**
     * Returns a list of debts by debtor
     * 
     * @return array 
     */
    public function findAll() : array
    {
        try {
            $debts = $this->crud->query(
                "SELECT debtor.nome, debtor.nr_cpf_cnpj, debt.dt_divida, debt.dt_vencimento
                FROM {$this->table_item_divida_devedor} AS item
                    INNER JOIN {$this->$table_devedor} AS debtor
                        ON item.id_devedor = debtor.id
                    LEFT JOIN {$this->table} AS debt
                        ON debt.id = item.id_divida
                    WHERE debtor.ic_ativo = 1");
            
            return count($debts) > 0 ? $debts : [];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    /**
     * Find a debt by id.
     * 
     * @param int $debtId
     */
    public function findById(int $debtId) : array
    {
        try {
            $debtor = $this->crud->query(
                "SELECT debtor.nome, debtor.nr_cpf_cnpj, debt.dt_divida, debt.dt_vencimento
                FROM {$this->table_item_divida_devedor} AS item
                    INNER JOIN {$this->$table_devedor} AS debtor
                        ON item.id_devedor = debtor.id
                    LEFT JOIN {$this->table} AS debt
                        ON debt.id = item.id_divida
                    WHERE debtor.ic_ativo = 1
                    AND debt.id = {$debtId}");

            return count($debtor) > 0 ? $debtor : [];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Save a new debt for a debtor.
     * 
     * @param array $data : array with debt data.
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
     * Update a debtor's existing debt.
     * 
     * @param int $debtId
     * @param array $data : array with debtor debt data to update.
     * @return bool
     */
    public function update(int $debtId, array $data) : bool
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
     * Delete a debtor's existing debt.
     * @param int $debtId
     */
    public function delete(int $debtId) : bool
    {
        try {
            if($this->crud->delete($this->table_item_divida_devedor, ["id" => $debtId]));
                return true;
            return false;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}