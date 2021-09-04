<?=$this->layout('../layouts/base', ["title" => "Sys Debtors - Dashboard", "titleSection" => "Dashboard"])?>

<?php $this->push('styles') ?>
    <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/components/card_cad.css"></link>
<?php $this->end() ?>

<?php

if(isset($this->data['countDebts'])) {
    $debts = $this->data['countDebts'];
    $allDebts = $debts['allDebts'];
    $currentDebts = $debts['currentDebts'];
    $nextDebts = $debts['nextDebts'];
    $paidDebts = $debts['paidDebts'];
}

?>

<?php $this->start('container') ?>

<section class="container mt-5">
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h100 py-2">
                <div class="card-body">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase text-animation">
                            Total de dívidas
                        </div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800 text-animation">
                            R$ <?= $allDebts ?? "0.00" ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h100 py-2">
                <div class="card-body">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase text-animation">
                            Dívida atual
                        </div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800 text-animation">
                            R$ <?= $currentDebts ?? "0.00" ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h100 py-2">
                <div class="card-body">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase text-animation">
                            Próximas dívidas
                        </div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800 text-animation">
                            R$ <?= $nextDebts ?? "0.00" ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h100 py-2">
                <div class="card-body">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase text-animation">
                            Total de dívidas pagas
                        </div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800 text-animation">
                            R$ <?= $paidDebts ?? "0.00" ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container mt-5">
    <h3>Cadastros</h3>
    <div class="row mt-3">
        <?=$this->insert('../layouts/card_cadastros', [
            "path" => "devedores", 
            "icon" => "person-fill.svg",
            "nameCard" => "Devedor"
        ])?>
        <?=$this->insert('../layouts/card_cadastros', [
            "path" => "dividas", 
            "icon" => "cash-coin.svg",
            "nameCard" => "Dívida"
        ])?>
    </div>
</section>

<?php $this->end() ?>