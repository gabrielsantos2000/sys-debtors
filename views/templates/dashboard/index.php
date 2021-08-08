<?=$this->layout('../base', ["title" => "Sys Debtors", "title2" => "Dashboard"])?>

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
                            R$ 100.000
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
                            R$ 25.000
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
                            Total de dívidas
                        </div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800 text-animation">
                            R$ 27.950
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
                            Total de dívidas
                        </div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800 text-animation">
                            R$ 1.000
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

<?php $this->end() ?>