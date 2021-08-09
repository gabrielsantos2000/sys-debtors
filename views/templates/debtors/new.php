<?=$this->layout('../base', ["title" => "Sys Debtors - Novo Devedor", "titleSection" => "Devedor"])?>

<?php $this->push('scripts') ?>
    <script src="<?=$this->e($url)?>public/assets/js/debtors.js"></script>
<?php $this->end() ?>

<?php $this->start('container') ?>
    <section class="container">
        <div class="card mt-3">
            <div class="card-header">
                Cadastrar novo devedor
            </div>
            <div class="card-body">
                <form id="newDebtor" method="post" action="<?=BASE_URL?>devedores">
                    <div class="row">
                        <div class="col-xl-6 col-sm-12">
                            <label for="nm_devedor">Nome</label>
                            <input type="text" id="nm_devedor" name="nm_devedor" class="form-control">
                        </div>
                        <div class="col-xl-6 col-sm-12">
                            <label for="dt_nascimento">Data de nascimento</label>
                            <input type="date" id="dt_nascimento" name="dt_nascimento" class="form-control">
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
                                maxlength="18">
                        </div>
                        <div class="col-xl-6 col-sm-12">
                            <label for="nm_logradouro">Logradouro</label>
                            <input 
                                type="text" 
                                id="nm_logradouro" 
                                name="nm_logradouro" 
                                class="form-control" 
                                placeholder="Ex: Rua Av. Nossa Senhora de Fátima">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-6 col-sm-12">
                            <label for="nr_logradouro">Número</label>
                            <input type="text" id="nr_logradouro" name="nr_logradouro" class="form-control" maxlength="4">
                        </div>
                        <div class="col-xl-6 col-sm-12">
                            <label for="nm_bairro">Bairro</label>
                            <input type="text" id="nm_bairro" name="nm_bairro" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-6 col-sm-12">
                            <label for="nm_estado">Estado</label>
                            <select id="nm_estado" name="nm_estado" class="form-select form-select mb-3">
                                <option value="0" selected>Selecione um estado</option>
                                <option value="1">São Paulo</option>
                                <option value="2">Rio de Janeiro</option>
                                <option value="3">Santa Catarina</option>
                            </select>
                        </div>
                        <div class="col-xl-6 col-sm-12">
                            <label for="nm_cidade">Cidade</label>
                            <select id="nm_cidade" name="nm_cidade" class="form-select form-select mb-3">
                                <option value="0" selected>Selecione uma cidade</option>
                                <option value="1">Santos</option>
                                <option value="2">São Vicente</option>
                                <option value="3">Guarujá</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-12">
                            <button type="submit" class="btn btn-primary float-end ms-2">Cadastrar</button>
                            <a href="<?=$this->e($url)?>" class="btn btn-outline-danger float-end">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
<?php $this->end() ?>