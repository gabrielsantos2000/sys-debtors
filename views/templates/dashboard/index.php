<?=$this->layout('../layouts/base', ["title" => "Sys Debtors - Dashboard", "titleSection" => "Dashboard"])?>

<?php $this->push('styles') ?>
    <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/components/card_cad.css"></link>
<?php $this->end() ?>

<?php $this->push('scripts') ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="<?=BASE_URL?>public/assets/js/charts.js"></script>
<?php $this->end() ?>

<?php

if(isset($this->data['countDebts'])) {
    $debts = $this->data['countDebts'];
    $allDebts = $debts['allDebts'];
    $currentDebts = $debts['currentDebts'];
    $nextDebts = $debts['nextDebts'];
    $lastDebt = $debts['lastDebt'];
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
                            R$ <?= $allDebts ?>
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
                            R$ <?= $currentDebts ?>
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
                            R$ <?= $nextDebts ?>
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
                            Última dívida cadastrada
                        </div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800 text-animation">
                            R$ <?= $lastDebt ?>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-arrow-up fa-2x text-gray-300 icon-animarion"></i>
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
            "path" => "devedores/create", 
            "icon" => "person-fill.svg",
            "nameCard" => "Devedor"
        ])?>
        <?=$this->insert('../layouts/card_cadastros', [
            "path" => "dividas/create", 
            "icon" => "cash-coin.svg",
            "nameCard" => "Dívida"
        ])?>
    </div>
</section>

<section class="container mt-5">
    <div class="row">
        <div class="col-xl-6 col-md-12">
            <div id="chart_div"></div>
        </div>
    </div>
</section>

<?php $this->end() ?>