<?php

namespace App\Controllers;

use App\Models\Debt as DebtModel;
use App\Models\Debtor as DebtorModel;
use App\Models\ItemDebtorDebt as ItemDebtorDebtModel;

use App\Providers\TemplateProvider;

class Debt
{
    /** @var instance */
    private $debtModel;

    /** @var instance */
    private $debtorModel;

    /** @var instance */
    private $addressModel;

    /** @var instance */
    private $itemDebtorDebtModel;

    /** @var instance */
    private $template;

    /**
     * @param $dbConfig basic database settings.
     */
    public function __construct()
    {
        $this->debtModel = new DebtModel();
        $this->debtorModel = new DebtorModel();
        $this->itemDebtorDebtModel = new ItemDebtorDebtModel();
        $this->template = new TemplateProvider();
    }

    /**
     * Get all debts by debtors.
     */
    public function index()
    {
        $debts = $this->debtModel->findAll();
        return $this->template->view('debt', 'index', ['debts' => $debts]);
    }

    /**
     * Returns the view to create the debtor.
     * 
     * @return mixed
     */
    public function create()
    {
        $debtors = $this->debtorModel->findAll();
        $debtors = count($debtors) > 0 ? $debtors : [];

        $natures = $this->debtModel->getAllDebtNatures();

        return $this->template->view('debt', 'new', ["debtors" => $debtors, 'natures' => $natures]);
    }

    /**
     * Save a new debtor.
     * 
     * @param array $data
     */
    public function store(array $data)
    {
        if(empty($data))
            return $this->template->message('Verifique se você preencheu todos os campos.')->view('debt', 'index');
        
        $storeDebt = [];
        $storeDebt['nm_titulo'] = $data['nm_titulo'];
        $storeDebt['ds_titulo'] = $data['ds_titulo'];
        $storeDebt['vl_divida'] = str_replace(",", ".", (str_replace(".", "",($data['vl_divida']))));
        $storeDebt['dt_divida'] = $data['dt_divida'];
        $storeDebt['dt_vencimento'] = $data['dt_vencimento'];
        $storeDebt['id_natureza_divida'] = $data['id_natureza'];
        $storeDebt['ic_ativo'] = 1;
        $storeDebt['created_at'] = date('Y-m-d H:i:s');

        if($debtId = $this->debtModel->insert($storeDebt)) {
            $itemDebtorDebtModel = [];
            $itemDebtorDebtModel['id_devedor'] = $data['id_devedor'];
            $itemDebtorDebtModel['id_divida'] = $debtId;

            if($this->itemDebtorDebtModel->insert($itemDebtorDebtModel))
                return $this->template->message("success", "Dívida cadastrada com sucesso!")->view('dashboard', 'index');
            else
                $this->debtorModel->delete($debtId);
        }

        return $this->template->message("error", "Erro ao cadastrar dívida para o devedor.")->view('debt', 'new');
    }

    /**
     * Edit a existing debtor.
     * 
     * @param array $debtId
     */
    public function edit($debtId)
    {
        if(!is_null($debtId['debtid']) && is_numeric($debtId['debtid'])) {
            $debtId = $debtId['debtid'];
            $debt = $this->debtModel->findById($debtId);

            if(!empty($debt)) {
                $debtors = $this->debtorModel->findAll();
                $debtors = count($debtors) > 0 ? $debtors : [];
                
                $natures = $this->debtModel->getAllDebtNatures();

                return $this->template->view('debt', 'new', [
                    "debt" => $debt, 
                    "debtors" => $debtors, 
                    'natures' => $natures
                ]);
            }
        }

        return $this->template->message("error", "Erro ao buscar dívida.")->view('dashboard', 'index');
    }

    /**
     * Update a existing debtor.
     * 
     * @param array $data
     */
    public function update($data)
    {
        if(!is_null($data['debtid']) && is_numeric($data['debtid'])) {
            $debtId = $data['debtid'];
            $debt = $this->debtModel->findById($debtId);

            if(!empty($debt)) {
                $editDebt = [];
                $editDebt['nm_titulo'] = $data['nm_titulo'];
                $editDebt['ds_titulo'] = $data['ds_titulo'];
                $editDebt['vl_divida'] = str_replace(",", ".", (str_replace(".", "",($data['vl_divida']))));
                $editDebt['dt_divida'] = $data['dt_divida'];
                $editDebt['dt_vencimento'] = $data['dt_vencimento'];
                $editDebt['id_natureza_divida'] = $data['id_natureza'];
                $editDebt['updated_at'] = date('Y-m-d H:i:s');

                if($this->debtModel->update($debtId, $editDebt)) {
                    return $this->template->message("success","Dívida editada com sucesso!")->view('dashboard', 'index');
                }
                
                return $this->template->message("error", "Erro ao editar dívida para o devedor.")->view('debt', 'new');
            }

            return $this->template->message("warning", "Dívida não encontratada no sistema.")->view('debt', 'index');
        }

        return $this->template->message("info", "Verifique se você preencheu todos os campos.")->view('debt', 'index');
    }

    /**
     * Deletes a existing debt.
     *
     * @param array $data
     */
    public function destroy($data)
    {
        if(!is_null($data['debtid']) && is_numeric($data['debtid'])) {
            if($this->debtModel->delete($data['debtid'])) 
                return $this->template->message("success","Dívida deletada com sucesso!")->view('debt', 'index');
        }

        return $this->template->message("error", "Erro ao deletar dívida para o devedor.")->view('debt', 'index');

    }

}