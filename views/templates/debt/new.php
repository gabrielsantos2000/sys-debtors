<?=$this->layout('../base', ["title" => "Sys Debtors - Nova Dívida", "titleSection" => "Dívida"])?>

<?php $this->push('scripts') ?>
    <script src="<?=$this->e($url)?>public/assets/js/debtors.js"></script>
<?php $this->end() ?>

<?php $this->start('container') ?>
    <section class="container">
        <div class="card mt-3">
            <div class="card-header">
                Cadastrar nova dívida
            </div>
            <div class="card-body">
                <form id="newDebt" method="post" action="<?=BASE_URL?>dividas">
                    <div class="row">
                        <div class="col-12">
                            <label for="nm_titulo">Título</label>
                            <input type="text" id="nm_titulo" name="nm_titulo" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-6 col-sm-12">
                            <label for="nm_devedor">Devedor</label>
                            <select id="nm_devedor" name="nm_devedor" class="form-select form-select mb-3">
                                <option value="0" selected>Selecione um devedor</option>
                                <?php foreach ($this->data['debtors'] as $key => $debtor): ?>
                                    <option value="<?=$debtor['id']?>"><?=$debtor['nm_devedor']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-xl-6 col-sm-12">
                            <label for="vl_divida">Valor da dívida</label>
                            <input 
                                type="text" 
                                id="vl_divida" 
                                name="vl_divida" 
                                class="form-control" 
                                maxlength="10"
                                placeholder="Ex: 10.000,00"
                            >
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-6 col-sm-12">
                            <label for="dt_divida">Data da dívida</label>
                            <input type="date" id="dt_divida" name="dt_divida" class="form-control">
                        </div>
                        <div class="col-xl-6 col-sm-12">
                            <label for="dt_vencimento">Data de vencimeto</label>
                            <input type="date" id="dt_vencimento" name="dt_vencimento" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-6 col-sm-12">
                            <label for="nm_natureza">Natureza</label>
                            <select id="nm_natureza" name="nm_natureza" class="form-select form-select mb-3">
                                <option value="0" selected>Selecione a natureza da dívida</option>
                                <option value="1">São Paulo</option>
                                <option value="2">Rio de Janeiro</option>
                                <option value="3">Santa Catarina</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Descreva o motivo da dívida" id="ds_titulo" style="height: 100px"></textarea>
                                <label for="ds_titulo">Descrição</label>
                            </div>
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