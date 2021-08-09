<?php

namespace App\Controllers;

use App\Models\Debt as DebtModel;
use App\Models\Debtor as DebtorModel;

use App\Providers\TemplateProvider;

class Debt
{
    /** @var instance */
    private $debtModel;

    /** @var instance */
    private $debtorModel;

    /** @var instance */
    private $template;

    /**
     * @param $dbConfig basic database settings.
     */
    public function __construct()
    {
        $this->debtModel = new DebtModel();
        $this->debtorModel = new DebtorModel();
        $this->template = new TemplateProvider();
    }

    /**
     * Get all debts by debtors.
     */
    public function index()
    {
        $debts = $this->debtModel->findAll();
        return $this->template->view('debt', 'index', ['debts' => $debts, 'url' => BASE_URL]);
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

        return $this->template->view('debt', 'new', ["debtors" => $debtors]);
    }

    /**
     * 
     */
    public function show()
    {   

    }

    /**
     * Save a new debtor.
     * 
     * @param array $data
     */
    public function store(array $data)
    {
        if(empty($data))
            return $this->template->message('Verifique se você preencheu todos os campos.')->view('debtors', 'index');
        
        $storeDebtor['nm_titulo'] = $data['nm_titulo'];
        $storeDebtor['ds_titulo'] = $data['ds_titulo'];
        $storeDebtor['vl_divida'] = $data['vl_divida'];
        $storeDebtor['dt_divida'] = $data['dt_divida'];
        $storeDebtor['dt_vencimento'] = $data['dt_vencimento'];
        $storeDebtor['ic_ativo'] = 1;
        $storeDebtor['created_at'] = date('Y-m-d H:i:s');
    }

    /**
     * Edit a existing debtor.
     */
    public function edit()
    {

    }

    /**
     * Update a existing debtor.
     */
    public function update()
    {

    }
}