<?php

namespace App\Models;

use App\Database\Crud;

class Address
{
   /** @var instance */
    private $crud;

    /** @var string */
    private $table = "tb_endereco";

    /** @var string */
    private $table_item_cidade_estado = "tb_item_cidade_estado";

    /** @var string */
    private $table_estado = "tb_estado";

    /** @var string */
    private $table_cidade = "tb_cidade";

    public function __construct()
    {
        $this->crud = new Crud(DB_CONFIG);
    }

    /**
     * Find the debtor's address.
     * 
     * @param int $debtorId
     * @return array|\Exception
     */
    public function find(int $debtorId) : ?array
    {
        try {
            $address = $this->crud->query(
                "SELECT endereco.id, endereco.nm_logradouro, endereco.nr_logradouro, endereco.nm_bairro, 
                estado.sg_estado, cidade.nm_cidade, estado.id as stateId, cidade.id as cityId
                FROM {$this->table} AS endereco
                    INNER JOIN {$this->table_item_cidade_estado} AS estado_cidade
                        ON endereco.id_estado_cidade = estado_cidade.id
                    INNER JOIN {$this->table_estado} AS estado
                        ON estado_cidade.id_estado = estado.id
                    INNER JOIN {$this->table_cidade} AS cidade
                        ON estado_cidade.id_cidade = cidade.id
                WHERE endereco.id_devedor = {$debtorId}
                ORDER BY endereco.id DESC LIMIT 1"
            );

            return count($address) > 0 ? $address : [];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Save a new address for the debtor.
     * 
     * @param array $data : array with address data.
     * @return bool|\Exception
     */
    public function insert(array $data) : ?bool
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
     * Updates an existing address of the debtor.
     * 
     * @param int $debtId
     * @param array $data : array with debtor address data to update.
     * @return bool|\Exception
     */
    public function update(int $addressId, array $data) : ?bool
    {
        try {
            if($this->crud->update($this->table, $data, ["id" => $addressId]))
                return true;
            return false;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Deletes an existing debtor's address.
     * @param int $debtId
     * @return bool|\Exception
     */
    public function delete(int $debtId) : ?bool
    {
        try {
            if($this->crud->delete($this->table, ["id" => $debtId]));
                return true;
            return false;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}