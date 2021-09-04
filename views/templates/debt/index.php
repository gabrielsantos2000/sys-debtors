
<?php
    $debts = $this->data['debts'];
?>

<?=$this->layout('../layouts/base', ["title" => "Sys Debtors - Débitos", "titleSection" => "Dívdas dos devedores"])?>
<?php $this->start('container') ?>
    <section class="container mt-2">
        <div class="row mb-2">
            <div class="col-12">
                <a href="<?=BASE_URL?>dividas/create" class="btn btn-primary float-end ms-2">Nova Dívida</a>
                <a href="<?=BASE_URL?>" class="btn btn-outline-danger float-end">Voltar</a>
            </div>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                <th scope="col">Nome</th>
                <th scope="col">Título</th>
                <th scope="col">Dt. Dívida</th>
                <th scope="col">Dt. Vencimento</th>
                <th scope="col">Dívida</th>
                <th scope="col" class="text-center">Status</th>
                <th scope="col"  class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($debts as $key => $debt): ?>

                <tr>
                    <td><?= $debt['nm_devedor'] ?></td>
                    <td><?= $debt['nm_titulo'] ?></td>
                    <td><?= date('d/m/Y', strtotime($debt['dt_divida'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($debt['dt_vencimento'])) ?></td>
                    <td><?= $debt['vl_divida'] ?></td>
                    <td class="text-center"><?= $debt['statusPayment'] ?></td>
                    <td class="text-center">
                        <form action="<?=BASE_URL?>dividas/delete/<?= $debt['id'] ?>" method="post">
                            <a href="<?=BASE_URL?>dividas/edit/<?= $debt['id'] ?>" class="btn btn-outline-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
<?php $this->end() ?>