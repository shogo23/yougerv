<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/dist/css/app.css" />
    <script src="/dist/js/app.js"></script>
    <title><?= $title ?></title>
</head>
<body>
    <div class="main_container">
        <?= $this->include('assets/anon_nav') ?>
        
        <section>
            <?= $this->renderSection('content') ?>
        </section>
        
        <?= $this->include('templates/footer') ?>
    </div>
</body>
</html>