<?php

namespace App\Controllers;

use App\Models\Debtor as DebtorModel;
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
    public function __construct($dbConfig)
    {
        $this->debtorModel = new DebtorModel($dbConfig);
        $this->template = new TemplateProvider();
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
        return $this->template->view('debtors', 'new');
    }

    /**
     * 
     */
    public function show()
    {

    }

    /**
     * 
     */
    public function dashboard()
    {
        return $this->template->view('dashboard', 'index');
    }

    /**
     * Save a new debtor.
     * 
     * @param array $data
     */
    public function store(array $data)
    {
        if(empty($data))
            return false;

        $isRegistred = $this->debtorModel->findByCpfOrCnpj($data['nr_cpf_cnpj']);

        if($isRegistred)
            return $this->template->message('Já existe esse cpf/cnpj cadastrado no sistema.')
                    ->view('debtors', 'new');

        $storeDebtor = [];

        $storeDebtor['nm_devedor'] = $data['nm_devedor'];
        $storeDebtor['dt_nascimento'] = $data['dt_nascimento'];
        $storeDebtor['nr_cpf_cnpj'] = $data['nr_cpf_cnpj'];
        $storeDebtor['ic_ativo'] = $data['ic_ativo'];
        $storeDebtor['created_at'] = date('Y-m-d H:i:s');

        $this->debtorModel->insert($storeDebtor);

        return $this->template->message('Devedor cadastrado com sucesso!')
                ->view('dashboard', 'index');
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