<?php

namespace App\Models;

use App\Database\Crud;

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

    /** @var string */
    private $table_natureza_divida = "tb_natureza_divida";

    /** @var array */
    public const PENDING_PAYMENT = '<i class="bi bi-exclamation-circle-fill" style="color: #dc3545; cursor: pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="Pagamento pendente"></i>';

    /** @var array */
    public const PAID_OUT = '<i class="bi bi-check-circle-fill" style="color: #20c997; cursor: pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="Paga"></i>';

    public function __construct()
    {
        $this->crud = new Crud(DB_CONFIG);
    }

    /**
     * Returns a list of debts by debtor.
     * 
     * @return array|\Exception
     */
    public function findAll(): ?array
    {
        try {
            $debts = $this->crud->query(
                sprintf(
                    "SELECT debt.id,debtor.nm_devedor, debt.nm_titulo, debtor.nr_cpf_cnpj, 
                    debt.dt_divida, debt.dt_vencimento, debt.vl_divida,
                    CASE WHEN 
                        debt.dt_vencimento >= DATE(NOW())  
                    THEN '%s'
                    WHEN 
                        debt.dt_vencimento < DATE(NOW())
                    THEN '%s'
                    END as statusPayment
                    FROM {$this->table_item_divida_devedor} AS item
                        INNER JOIN {$this->table_devedor} AS debtor
                            ON item.id_devedor = debtor.id
                        LEFT JOIN {$this->table} AS debt
                            ON debt.id = item.id_divida
                        WHERE debtor.ic_ativo = 1",
                        self::PENDING_PAYMENT, self::PAID_OUT
                    )
                );
            
            return count($debts) > 0 ? $debts : [];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    /**
     * Find a debt by id.
     * 
     * @param int $debtId
     * @return bool|\Exception
     */
    public function findById(int $debtId): ?array
    {
        try {
            $debt = $this->crud->query(
                "SELECT debt.id, debtor.id as debtor_id, debtor.nr_cpf_cnpj, debt.vl_divida, 
                debt.dt_divida, debt.dt_vencimento, debt.nm_titulo, debt.ds_titulo, natureza.nm_natureza
                FROM {$this->table_item_divida_devedor} AS item
                    INNER JOIN {$this->table_devedor} AS debtor
                        ON item.id_devedor = debtor.id
                    INNER JOIN {$this->table} AS debt
                        ON debt.id = item.id_divida
                    INNER JOIN {$this->table_natureza_divida} AS natureza
                        ON debt.id_natureza_divida = natureza.id
                WHERE debtor.ic_ativo = 1
                AND debt.ic_ativo = 1
                AND debt.id = {$debtId}");
        
            return count($debt) > 0 ? $debt : [];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Save a new debt for a debtor.
     * 
     * @param array $data : array with debt data.
     * @return int|bool|\Exception
     */
    public function insert(array $data): ?int
    {
        try {
            if($this->crud->insert($this->table, $data))
                return $this->crud->lastId();
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
     * @return bool|\Exception
     */
    public function update(int $debtId, array $data): ?bool
    {
        try {
            if($this->crud->update($this->table, $data, ["id" => $debtId]))
                return true;
            return false;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Delete a debtor's existing debt.
     * @param int $debtId
     * @return bool|\Exception
     */
    public function delete(int $debtId): ?bool
    {
        try {
            if($this->crud->delete($this->table, ["id" => $debtId]));
                return true;
            return false;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 
     * @return array
     */
    public function getAllDebtNatures(): array
    {
        try {
            $allNarutes = $this->crud->query(
                "SELECT id, nm_natureza FROM {$this->table_natureza_divida}"
            );
            
            return count($allNarutes) > 0 ? $allNarutes : [];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}