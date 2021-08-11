<?php

namespace App\Models;

use App\Database\Crud;

class Dashboard
{
   /** @var instance */
    private $crud;

    /** @var string */
    private $table_devedor = "tb_devedor";

    /** @var string */
    private $table_item_divida_devedor = "tb_item_divida_devedor";

    /** @var string */
    private $table_divida = "tb_divida";

    public function __construct()
    {
        $this->crud = new Crud(DB_CONFIG);
    }

    /**
     * Search all active debts in the system
     * 
     * @return array|\Exception
     */
    public function fetchAllDebts(): ?array
    {
        try {
            $allDebts = $this->crud->query(
                "SELECT SUM(debt.vl_divida) as allDebts 
                FROM {$this->table_item_divida_devedor} AS item
                    INNER JOIN {$this->table_devedor} AS debtor
                        ON item.id_devedor = debtor.id
                    LEFT JOIN {$this->table_divida} AS debt
                        ON debt.id = item.id_divida
                    WHERE debtor.ic_ativo = 1 
                    AND debt.ic_ativo = 1"
                );
            
            return count($allDebts) > 0 ? $allDebts[0]: [];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Search the current month's current debts.
     * 
     * @return array|\Exception
     */
    public function fetchCurrentDebts(): ?array
    {
        try {
            $currentDebts = $this->crud->query(
                "SELECT SUM(debt.vl_divida) as currentDebts
                FROM {$this->table_item_divida_devedor} AS item
                    INNER JOIN {$this->table_devedor} AS debtor
                        ON item.id_devedor = debtor.id
                    LEFT JOIN {$this->table_divida} AS debt
                        ON debt.id = item.id_divida
                    WHERE debtor.ic_ativo = 1
                    AND debt.ic_ativo = 1
                    AND debt.dt_divida <= debt.dt_vencimento
                    AND month(debt.dt_vencimento) = month(NOW())"
            );
            
            return count($currentDebts) > 0 ? $currentDebts[0] : [];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Search the next debts.
     * 
     * @return array|\Exception
     */
    public function fetchNextDebts(): ?array
    {
        try {
            $nextDebts = $this->crud->query(
                "SELECT SUM(debt.vl_divida) as nextDebts
                FROM {$this->table_item_divida_devedor} AS item
                    INNER JOIN {$this->table_devedor} AS debtor
                        ON item.id_devedor = debtor.id
                    LEFT JOIN {$this->table_divida} AS debt
                        ON debt.id = item.id_divida
                    WHERE debtor.ic_ativo = 1
                    AND debt.ic_ativo = 1
                    AND month(debt.dt_vencimento) > month(NOW())"
            );
            
            return count($nextDebts) > 0 ? $nextDebts[0] : [];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Search for the last debt.
     * 
     * @return array|\Exception
     */
    public function findLastDebt(): ?array
    {
        try {
            $lastDebt = $this->crud->query(
                "SELECT debt.vl_divida as lastDebt
                FROM {$this->table_item_divida_devedor} AS item
                    INNER JOIN {$this->table_devedor} AS debtor
                        ON item.id_devedor = debtor.id
                    LEFT JOIN {$this->table_divida} AS debt
                        ON debt.id = item.id_divida
                    WHERE debtor.ic_ativo = 1
                    AND debt.ic_ativo = 1
                    ORDER BY debt.id LIMIT 1"
            );
            
            return count($lastDebt) > 0 ? $lastDebt[0] : [];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}