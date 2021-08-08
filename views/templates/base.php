<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$this->e($title)?></title>

    <link rel="stylesheet" href="public/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/assets/css/dashboard.css">

    <script src="public/assets/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Sys Debtors</a>
            </div>
        </nav>
    </header>
    <main class="container-fluid">
        <section class="container mt-5">
            <?php if($this->e($title2)): ?>
                <h2> <?=$this->e($title2)?> </h2>
            <?php else: ?>
                <h2>Dashboard</h2>
            <?php endif; ?>
        </section>

        <?= $this->section('container') ?>
    </main>
</body>
</html>