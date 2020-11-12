<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <title><?= $tile ?? 'Mon site' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body class="d-flex flex-column h-100">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a href="#" class="navbar-brand">Mon site</a>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="<?= $router->url('admin_posts')?>" class="nav-link">Articles</a>
        </li>
        <li class="nav-item">
            <a href="<?= $router->url('admin_categories')?>" class="nav-link">Gatégories</a>
        </li>
    </ul>
</nav>
<div class="container mt-4">
    <?= $content ?>
</div>

<footer class="bg-light py-4 footer mt-auto">
    <div class="container">
        <!-- pour savoir en combien de temps la page charger, on multiplie le temps pour l'avoir en seconde -->
        <?php if (defined('DEBUG_TIME')): ?>
            Page générer en  <?= round(1000 * (microtime(true) - DEBUG_TIME) )?> ms
        <?php endif ?>
    </div>
</footer>
</body>
</html>