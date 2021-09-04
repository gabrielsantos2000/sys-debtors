<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$this->e($title)?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="<?=BASE_URL?>public/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/_reset.css">
    <?=$this->section('styles')?>

    <script src="<?=BASE_URL?>public/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=BASE_URL?>public/assets/js/jquery.min.js"></script>
    <script src="<?=BASE_URL?>public/assets/js/jquery.mask.js"></script>
    <script src="<?=BASE_URL?>public/assets/js/validateForm.js"></script>
    <?=$this->section('scripts')?>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?=BASE_URL?>">Sys Debtors</a>
            </div>
        </nav>
    </header>
    <main class="container-fluid">
        <section class="container alert-error mt-5" style="display: <?= $this->e(isset($msg)) ? "block" : "none" ?>">
            <div class="alert alert-primary d-flex align-items-center" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" 
                    height="24" 
                    fill="currentColor" 
                    class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" 
                    viewBox="0 0 16 16" 
                    role="img" 
                    aria-label="Warning:">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <div class="alert-message-error">
                    <?= $this->e(isset($msg)) ? $this->e($msg) : "" ?>
                </div>
            </div>
        </section>
        <section class="container mt-5">
            <?php if($this->e($titleSection)): ?>
                <h2> <?=$this->e($titleSection)?> </h2>
            <?php else: ?>
                <h2>Dashboard</h2>
            <?php endif; ?>
        </section>

        <?= $this->section('container') ?>
    </main>
</body>
</html>