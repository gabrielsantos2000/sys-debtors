<?php 
    if(isset($this->data['debtor'])) {
        $debtor = $this->data['debtor'][0];
        $address = $this->data['address'][0];

        $debtorId = $debtor['id'];
        $debtorName = $debtor['nm_devedor'];
        $debtorBirth = $debtor['dt_nascimento'];
        $debtorNrCnpjCpf = $debtor['nr_cpf_cnpj'];
        $debtorAddress = $address['nm_logradouro'];
        $debtorNumberAddress = $address['nr_logradouro'];
        $debtorDistrict = $address['nm_bairro'];
        $debtorStateId = $address['stateId'];
        $debtorCityId = $address['cityId'];
    }
?>

<?=$this->layout('../layouts/base', ["title" => "Sys Debtors - Novo Devedor", "titleSection" => "Devedor"])?>

<?php $this->push('scripts') ?>
    <script type="text/javascript" src="<?=BASE_URL?>public/assets/js/debtors.js"></script>
    <script type="text/javascript" src="<?=BASE_URL?>public/assets/js/ajax/item_state_city.js"></script>
<?php $this->end() ?>

<?php $this->start('container') ?>
    <section class="container">
        <div class="card mt-3">
            <div class="card-header">
                Cadastrar novo devedor
            </div>
            <div class="card-body">
                <form 
                    id="newDebtor" method="post" 
                    action="<?=BASE_URL . (isset($debtorId) ? "devedores/update/".$debtorId : "devedores") ?>"
                >
                    <div class="row">
                        <div class="col-xl-6 col-sm-12">
                            <label for="nm_devedor">Nome</label>
                            <input 
                                type="text" 
                                id="nm_devedor" 
                                name="nm_devedor" 
                                class="form-control"
                                value="<?= isset($debtorName) ? $debtorName : "" ?>"
                            >
                        </div>
                        <div class="col-xl-6 col-sm-12">
                            <label for="dt_nascimento">Data de nascimento</label>
                            <input 
                                type="date" 
                                id="dt_nascimento" 
                                name="dt_nascimento" 
                                class="form-control"
                                value="<?= isset($debtorBirth) ? $debtorBirth : "" ?>"
                            >
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-6 col-sm-12">
                            <label for="nr_cpf_cnpj">CPF/CNPJ</label>
                            <input 
                                type="text" id="nr_cpf_cnpj" 
                                name="nr_cpf_cnpj" 
                                class="form-control" 
                                placeholder="Ex: 999.999.999-99"
                                maxlength="18"
                                value="<?= isset($debtorNrCnpjCpf) ? $debtorNrCnpjCpf : "" ?>"
                            >
                        </div>
                        <div class="col-xl-6 col-sm-12">
                            <label for="nm_logradouro">Logradouro</label>
                            <input 
                                type="text" 
                                id="nm_logradouro" 
                                name="nm_logradouro" 
                                class="form-control" 
                                placeholder="Ex: Rua Av. Nossa Senhora de Fátima"
                                value="<?= isset($debtorAddress) ? $debtorAddress : "" ?>"
                            >
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-6 col-sm-12">
                            <label for="nr_logradouro">Número</label>
                            <input 
                                type="text" 
                                id="nr_logradouro" 
                                name="nr_logradouro" 
                                class="form-control" 
                                maxlength="4"
                                value="<?= isset($debtorNumberAddress) ? $debtorNumberAddress : "" ?>"
                            >
                        </div>
                        <div class="col-xl-6 col-sm-12">
                            <label for="nm_bairro">Bairro</label>
                            <input 
                                type="text" 
                                id="nm_bairro" 
                                name="nm_bairro" 
                                class="form-control"
                                value="<?= isset($debtorDistrict) ? $debtorDistrict : "" ?>"
                            >
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-6 col-sm-12">
                            <label for="nm_estado">Estado</label>
                            <select id="nm_estado" name="id_estado" class="form-select form-select mb-3"
                                <?= isset($stateId) ? "disabled='disabled'" : ""?> 
                            >
                                <option value="0" selected>Selecione um estado</option>
                                <?php foreach ($this->data['states'] as $key => $state): ?>
                                    <option value="<?=$state['id']?>"
                                        <?= isset($debtorStateId) && $debtorStateId ==  $state['id'] 
                                            ? ' selected="selected"' 
                                            : ""?>
                                    >
                                        <?=$state['nm_estado']?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-xl-6 col-sm-12">
                            <label for="nm_cidade">Cidade</label>
                            <select id="nm_cidade" name="id_cidade" class="form-select form-select mb-3"
                                <?= isset($cityId) ? "disabled='disabled'" : ""?> 
                            >
                                <option value="0" selected>Selecione uma cidade</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-12">
                            <button 
                                type="submit" 
                                class="btn btn-primary float-end ms-2">
                                <?= isset($debtorId) ? "Editar" : "Cadastrar" ?>
                            </button>
                            <a href="<?=BASE_URL?>devedores" class="btn btn-outline-danger float-end">Voltar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
<?php $this->end() ?>