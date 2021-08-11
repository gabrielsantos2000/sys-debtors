<?php

namespace App\Models;

use App\Database\Crud;

class ItemDebtorDebt
{
   /** @var instance */
    private $crud;

    /** @var string */
    private $table = "tb_item_divida_devedor";

    public function __construct()
    {
        $this->crud = new Crud(DB_CONFIG);
    }

    /**
     * Save a new debt item for a debtor.
     * 
     * @param array $data : matrix with debt and debtor data.
     * @return int|bool|\Exception
     */
    public function insert(array $data) : ?int
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
     * Deletes an existing debtor's debt item.
     * @param int $debtorId
     * @param int $debtId
     * @return bool|\Exception
     */
    public function delete(int $debtorId, int $debtId) : ?bool
    {
        try {
            if($this->crud->delete($this->table_item_divida_devedor, ["id_devedor" => $debtorId, "id_divida" => $debtId]));
                return true;
            return false;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}