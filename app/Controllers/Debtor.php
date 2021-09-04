<?php

namespace App\Controllers;

use App\Models\Debtor as DebtorModel;
use App\Models\Address as AddressModel;
use App\Models\ItemStateCity as ItemStateCityModel;
use App\Models\Dashboard as DashboardModel;

use App\Providers\TemplateProvider;

class Debtor
{
    /** @var instance */
    private $debtorModel;

    /** @var instance */
    private $template;

    /**
     * @param $dbConfig basic database settings.
     */
    public function __construct()
    {
        $this->debtorModel = new DebtorModel();
        $this->addressModel = new AddressModel();
        $this->itemStateCityModel = new ItemStateCityModel();
        $this->template = new TemplateProvider();
        $this->dashboardModel = new DashboardModel();
    }

    /**
     * Get all debtors.
     */
    public function index()
    {
        $debtors = $this->debtorModel->findAll();
        return $this->template->view('debtors', 'index', ['debtors' => $debtors]);
    }

    /**
     * Returns the view to create the debtor.
     * 
     * @return mixed
     */
    public function create()
    {
        $states = $this->itemStateCityModel->findAllStates();
        $cities = $this->itemStateCityModel->findAllCities();

        return $this->template->view('debtors', 'new', ['states' => $states, 'cities' => $cities]);
    }

    /**
     * 
     */
    public function dashboard()
    {
        $allDebts = $this->dashboardModel->fetchAllDebts();
        $currentDebts = $this->dashboardModel->fetchCurrentDebts();
        $nextDebts = $this->dashboardModel->fetchNextDebts();
        $paidDebts = $this->dashboardModel->fetchPaidDebts();

        return $this->template->view('dashboard', 'index', [
            'countDebts'=>[
                'allDebts' => $allDebts,
                'currentDebts' => $currentDebts, 
                'nextDebts' => $nextDebts,
                'paidDebts' => $paidDebts
            ]
        ]);
    }

    /**
     * Save a new debtor.
     * 
     * @param array $data
     */
    public function store(array $data)
    {
        if(empty($data))
            return $this->template->message('info', 'Verifique se você preencheu todos os campos.')->view('debtors', 'index');

        $isRegistred = $this->debtorModel->findByCpfOrCnpj($data['nr_cpf_cnpj']);
        if($isRegistred)
            return $this->template->message('info', 'Já existe esse cpf/cnpj cadastrado no sistema.')->view('debtors', 'new');

        $storeDebtor = [];

        $storeDebtor['nm_devedor'] = $data['nm_devedor'];
        $storeDebtor['dt_nascimento'] = $data['dt_nascimento'];
        $storeDebtor['nr_cpf_cnpj'] = $data['nr_cpf_cnpj'];
        $storeDebtor['ic_ativo'] = 1;
        $storeDebtor['created_at'] = date('Y-m-d H:i:s');

        if($debtorId = $this->debtorModel->insert($storeDebtor)) {

            $stateCityId = $this->itemStateCityModel->findStateAndCityId($data['id_estado'], $data['id_cidade']);
            if(!empty($stateCityId)) {
                $storeAddress = [];
                $storeAddress['nm_logradouro'] = $data['nm_logradouro'];
                $storeAddress['nr_logradouro'] = $data['nr_logradouro'];
                $storeAddress['nm_bairro'] = $data['nm_bairro'];
                $storeAddress['id_estado_cidade'] = $stateCityId;
                $storeAddress['id_devedor'] = $debtorId;

                if($this->addressModel->insert($storeAddress))
                    return $this->template->message('success', 'Devedor cadastrado com sucesso!')->view('dashboard', 'index');
                else
                    $this->debtorModel->delete($debtorId);
            }
        }

        return $this->template->message('error', 'Problemas ao cadastrar novo devedor!')->view('debtors', 'new');
    }

    /**
     * Edit a existing debtor.
     */
    public function edit($debtorId)
    {
        if(!is_null($debtorId['debtorid']) && is_numeric($debtorId['debtorid'])) {
            $debtorId = $debtorId['debtorid'];
            $debtor = $this->debtorModel->findById($debtorId);

            if(!empty($debtor)) {
                $debtorAddress = $this->addressModel->find($debtorId);

                $states = $this->itemStateCityModel->findAllStates();
                $cities = $this->itemStateCityModel->findAllCities();

                return $this->template->view('debtors', 'new', [
                    'debtor' => $debtor, 
                    'address' => $debtorAddress,
                    'states' => $states,
                    'cities' => $cities
                ]);
            }
        }

        return $this->template->message("error", "Erro ao buscar devedor.")->view('dashboard', 'index');
    }

    /**
     * Update a existing debtor.
     */
    public function update($data)
    {
        if(!is_null($data['debtorid']) && is_numeric($data['debtorid'])) {
            $debtorId = $data['debtorid'];
            $debtor = $this->debtorModel->findById($debtorId);

            if(!empty($debtor)) {
                $editDebtor = [];
                $editDebtor['nm_devedor'] = $data['nm_devedor'];
                $editDebtor['dt_nascimento'] = $data['dt_nascimento'];
                $editDebtor['nr_cpf_cnpj'] = $data['nr_cpf_cnpj'];
                $editDebtor['updated_at'] = date('Y-m-d H:i:s');

                if($this->debtorModel->update($debtorId, $editDebtor)) {
                    $stateCityId = $this->itemStateCityModel->findStateAndCityId($data['id_estado'], $data['id_cidade']);

                    if(!empty($stateCityId)) {
                        $editOrStoreAddress = [];
                        $editOrStoreAddress['nm_logradouro'] = $data['nm_logradouro'];
                        $editOrStoreAddress['nr_logradouro'] = $data['nr_logradouro'];
                        $editOrStoreAddress['nm_bairro'] = $data['nm_bairro'];
                        $editOrStoreAddress['id_estado_cidade'] = $stateCityId;

                        $debtorAddress = $this->addressModel->find($debtorId);
                        if(empty($debtorAddress))  {
                            $editOrStoreAddress['id_devedor'] = $debtorId;
                            $this->addressModel->insert($editOrStoreAddress);
                        } else {
                            $this->addressModel->update($debtorAddress[0]['id'], $editOrStoreAddress);
                        }
                    }

                    return $this->template->message("success","Devedor editada com sucesso!")->view('dashboard', 'index');
                }
                
                return $this->template->message("error", "Erro ao editar devedor para o devedor.")->view('debtor', 'new');
            }

            return $this->template->message("warning", "Devedor não encontratada no sistema.")->view('debtor', 'index');
        }

        return $this->template->message("info", "Verifique se você preencheu todos os campos.")->view('debtor', 'index');
    }

    /**
     * Deletes a existing debtor.
     */
    public function destroy($idDebtor)
    {
        if(empty($idDebtor)) 
            return $this->template->message("error", "Erro ao deletar devedor.")->view('dashboard', 'index');
    }
}