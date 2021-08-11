<?php

namespace App\Models;

use App\Database\Crud;

class ItemStateCity
{
   /** @var instance */
    private $crud;

    /** @var string */
    private $table = "tb_item_cidade_estado";

    /** @var string */
    private $table_estado = "tb_estado";
    
    /** @var string */
    private $table_cidade = "tb_cidade";
    
    public function __construct()
    {
        $this->crud = new Crud(DB_CONFIG);
    }

    /** 
     * Search for the key to the state and the city.
     * 
     * @param int $stateId
     * @param int $cityId
     * @return int|\Exception
    */
    public function findStateAndCityId(int $stateId, int $cityId): ?int
    {
        try {
            $itemStateCity = $this->crud->query(
                "SELECT item.id FROM {$this->table} item
                    INNER JOIN {$this->table_estado} estado
                        ON item.id_estado = estado.id
                    INNER JOIN {$this->table_cidade} cidade
                        ON item.id_cidade = cidade.id
                WHERE item.id_estado = {$stateId} AND item.id_cidade = {$cityId}"
            );

            return count($itemStateCity) > 0 ? $itemStateCity[0]['id'] : 0;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    /** 
     * Find all states.
     * 
     * @return array|\Exception
    */
    public function findAllStates(): ?array
    {
        try {
            $states = $this->crud->query(
                "SELECT id, nm_estado, sg_estado FROM {$this->table_estado}"
            );

            return count($states) > 0 ? $states : [];

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /** 
     * Find the state by id.
     * 
     * @param int $stateId
     * @return array|\Exception
    */
    public function findStateById(int $stateId): ?array
    {
        try {
            $state = $this->crud->query(
                "SELECT id, nm_estado, sg_estado FROM {$this->table_estado}
                WHERE id = {$stateId}"
            );

            return count($state) > 0 ? $state : [];

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /** 
     * Find all cities.
     * 
     * @return array|\Exception
    */
    public function findAllCities(): ?array
    {
        try {
            $cities = $this->crud->query(
                "SELECT cidade.id, cidade.nome FROM {$this->table_cidade}"
            );

            return count($cities) > 0 ? $cities : [];

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /** 
     * Find all cities by state id.
     * 
     * @param int $stateId
     * @return array|\Exception
    */
    public function findAllCitiesByStateId(int $stateId): ?array
    {
        try {
            $cities = $this->crud->query(
                "SELECT cidade.id, cidade.nome FROM {$this->table} item
                    INNER JOIN {$this->table_estado} estado
                        ON item.id_estado = estado.id
                    INNER JOIN {$this->table_cidade} cidade
                        ON item.id_cidade = cidade.id
                WHERE item.id_estado = {$stateId} AND item.id_cidade = {$cityId}"
            );

            return count($cities) > 0 ? $cities : [];

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Save a new address item for a debtor.
     * 
     * @param array $data : matrix with debt and debtor data.
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
     * Deletes an existing debtor's address item.
     * @param int $debtorId
     * @param int $debtId
     * @return bool|\Exception
     */
    public function delete(int $debtorId, int $debtId): ?bool
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