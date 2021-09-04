
<?php
    $debtors = $this->data['debtors'];
?>

<?=$this->layout('../layouts/base', ["title" => "Sys Debtors - Devedores", "titleSection" => "Devedores"])?>

<?php $this->start('container') ?>
    <section class="container mt-2">
        <div class="row mb-2">
            <div class="col-12">
                <a href="<?=BASE_URL?>devedores/create" class="btn btn-primary float-end ms-2">Novo Devedor</a>
                <a href="<?=BASE_URL?>" class="btn btn-outline-danger float-end">Voltar</a>
            </div>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                <th scope="col">Nome</th>
                <th scope="col">CPF/CNPJ</th>
                <th scope="col">Logradouro</th>
                <th scope="col">Número</th>
                <th scope="col">Bairro</th>
                <th scope="col">Estado</th>
                <th scope="col">Cidade</th>
                <th scope="col"  class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($debtors as $key => $debtor): ?>

                <tr>
                    <td><?= $debtor['nm_devedor'] ?></td>
                    <td><?= $debtor['nr_cpf_cnpj'] ?></td>
                    <td><?= $debtor['nm_logradouro'] ?></td>
                    <td><?= $debtor['nr_logradouro'] ?></td>
                    <td><?= $debtor['nm_bairro'] ?></td>
                    <td><?= $debtor['sg_estado'] ?></td>
                    <td><?= $debtor['nm_cidade'] ?></td>
                    <td  class="text-center">
                        <form action="<?=BASE_URL?>devedores/delete/<?= $debtor['id'] ?>" method="post">
                            <a href="<?=BASE_URL?>devedores/edit/<?= $debtor['id'] ?>" class="btn btn-outline-primary">
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