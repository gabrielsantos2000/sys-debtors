<?php 
    if(isset($this->data['debt'])) {
        $debt = $this->data['debt'][0];

        $debtId = $debt['id'];
        $title = $debt['nm_titulo'];
        $debtorId = $debt['debtor_id'];
        $debtValue = $debt['vl_divida'];
        $dtDebt = $debt['dt_divida'];
        $dueDate = $debt['dt_vencimento'];
        $natureName = $debt['nm_natureza'];
        $description = $debt['ds_titulo'];
    }
?>

<?=$this->layout('../layouts/base', [
    "title" => "Sys Debtors - " . isset($debtId) ? "Editar Dívida" : "Nova Dívida", 
    "titleSection" => "Dívida"
])?>

<?php $this->push('scripts') ?>
    <script src="<?=BASE_URL?>public/assets/js/debt.js"></script>
<?php $this->end() ?>

<?php $this->start('container') ?>
    <section class="container">
        <div class="card mt-3">
            <div class="card-header">
                Cadastrar nova dívida
            </div>
            <div class="card-body">
                <form 
                    id="newDebt" method="post" 
                    action="<?=BASE_URL . (isset($debtId) ? "dividas/update/".$debtId : "dividas") ?>"
                >
                    <?php if(isset($debtId)): ?>
                        <input type="hidden" name="_METHOD" value="PUT">
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-12">
                            <label for="nm_titulo">Título</label>
                            <input 
                                type="text" 
                                id="nm_titulo" 
                                name="nm_titulo" 
                                class="form-control"
                                value="<?= isset($title) ? $title : "" ?>"
                            >
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-6 col-sm-12">
                            <label for="id_devedor">Devedor</label>
                            <select id="nm_devedor" name="id_devedor" class="form-select form-select mb-3" 
                                <?= isset($debtorId) ? "disabled='disabled'" : ""?> 
                            >
                                <option value="0" selected>Selecione um devedor</option>
                                <?php foreach ($this->data['debtors'] as $key => $debtor): ?>
                                    <option value="<?=$debtor['id']?>"
                                        <?= isset($debtorId) && $debtorId ==  $debtor['id'] 
                                            ? ' selected="selected"' 
                                            : ""?>
                                    >
                                        <?=$debtor['nm_devedor']?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-xl-6 col-sm-12">
                            <label for="vl_divida">Valor da dívida</label>
                            <input 
                                type="text" 
                                id="vl_divida" 
                                name="vl_divida" 
                                class="form-control money" 
                                maxlength="10"
                                placeholder="Ex: 10.000,00"
                                value="<?= isset($debtValue) ? $debtValue : "" ?>"
                            >
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-6 col-sm-12">
                            <label for="dt_divida">Data da dívida</label>
                            <input 
                                type="date" 
                                id="dt_divida" 
                                name="dt_divida" 
                                class="form-control" 
                                value="<?= isset($dtDebt) ? $dtDebt : "" ?>"
                            >
                        </div>
                        <div class="col-xl-6 col-sm-12">
                            <label for="dt_vencimento">Data de vencimeto</label>
                            <input 
                                type="date" 
                                id="dt_vencimento" 
                                name="dt_vencimento" 
                                class="form-control"
                                value="<?= isset($dueDate) ? $dueDate : "" ?>"
                            >
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-6 col-sm-12">
                            <label for="nm_natureza">Natureza</label>
                            <select id="nm_natureza" name="id_natureza" class="form-select form-select mb-3">
                                <option value="0" selected>Selecione a natureza da dívida</option>
                                <?php foreach ($this->data['natures'] as $key => $nature): ?>
                                    <option value="<?=$nature['id']?>"
                                        <?= isset($natureName) && $natureName ==  $nature['nm_natureza'] 
                                            ? ' selected="selected"' 
                                            : ""?>
                                    >
                                        <?=$nature['nm_natureza']?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                        <div class="form-floating">
                            <textarea 
                                name="ds_titulo"
                                class="form-control" 
                                placeholder="Descreva o motivo da dívida" 
                                id="ds_titulo" 
                                style="height: 100px"><?= isset($description) ? $description : "" ?></textarea>
                                <label for="ds_titulo">Descrição</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-12">
                            <button 
                                type="submit" 
                                class="btn btn-primary float-end ms-2">
                                <?= isset($debtId) ? "Editar" : "Cadastrar" ?>
                            </button>
                            <a href="<?=BASE_URL?>" class="btn btn-outline-danger float-end">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
<?php $this->end() ?>