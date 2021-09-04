<?php

namespace App\Models;

use App\Database\Crud;

class Debtor
{
    /** @var instance */
    private $crud;

    /** @var string */
    private $table = "tb_devedor";

    /** @var string */
    private $table_endereco = "tb_endereco";

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
     * Return a list of debtors.
     * 
     * @return array|\Exception
     */
    public function findAll() : array
    {
        try {
            $debtors = $this->crud->query(
                "SELECT devedor.id, devedor.nm_devedor, devedor.nr_cpf_cnpj, endereco.nm_logradouro,
                endereco.nr_logradouro, endereco.nm_bairro, estado.sg_estado, cidade.nm_cidade
                FROM {$this->table} AS devedor
                    INNER JOIN {$this->table_endereco} AS endereco
                        ON devedor.id = endereco.id_devedor
                    INNER JOIN {$this->table_item_cidade_estado} AS estado_cidade
                        ON endereco.id_estado_cidade = estado_cidade.id
                    INNER JOIN {$this->table_estado} AS estado
                        ON estado_cidade.id_estado = estado.id
                    INNER JOIN {$this->table_cidade} AS cidade
                        ON estado_cidade.id_cidade = cidade.id
                WHERE ic_ativo = 1
                GROUP BY endereco.id_devedor
                ORDER BY devedor.nm_devedor"
            );

            return count($debtors) > 0 ? $debtors : [];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    /**
     * Find a debtor by id.
     * 
     * @param int $debtorId : debtor id.
     * @return array|\Exception
     */
    public function findById(int $debtorId) : array
    {
        try {
            $debtor = $this->crud->query("SELECT * FROM {$this->table} WHERE id = {$debtorId} AND ic_ativo = 1");

            return count($debtor) > 0 ? $debtor : [];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Save a new debtor
     * 
     * @param array $data : array with debtor data.
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
     * Update an existing debtor.
     * 
     * @param int $debtorId
     * @param array $data : array with debtor data to update.
     * @return bool|\Exception
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
     * @return bool|\Exception
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
     * @param string $cpfOrCnpj
     * @return bool\Exception
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