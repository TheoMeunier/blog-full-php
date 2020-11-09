<?php

use App\Model\Post;
use App\Conection;
use App\Url;

$title = 'Mon blog';

//on ce connecter a la base de donnée
$pdo = Conection::getPDO();

//numéro de la page courrante, la page par defaut est 1
$currentPage = Url::getPosstiveInt('page', 1);

// si la page <= 0 alors on returne une erreur
if ($currentPage <= 0) {
    throw new Exception('Numéro d epage invalide');
}

//on fait une requete pour compter le nombre d'acticle qu'on a
//et on lui demande recupere les info sous forme de tableau nurmérique
$count = (int)$pdo->query('SELECT COUNT(id) FROM post')->fetch(PDO::FETCH_NUM)[0];

//variable pour le nombre de page
$perPage = 12;

// on divise article par page
$pages = ceil($count / $perPage);

// si la page la page courrente > au nombre de page alors on returne une exeption
if ($currentPage > $pages) {
    throw new Exception('Cette page n\'existe pas');
}

//on calcule l'offset
$offset = $perPage * ($currentPage - 1);

//on fait la requete sql pour afficher 12 post
$query = $pdo->query("SELECT * FROM post ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");

//on recupère les 12 dernière données
$posts = $query->fetchAll(PDO::FETCH_CLASS, Post::class);

?>

<h1>Mon blog</h1>

<div class="row">
    <?php foreach ($posts as $post): ?>
        <div class="col-md-3 mb-3">
            <!--on importe le fichier card.php-->
            <?php require 'card.php' ?>
        </div>
    <?php endforeach ?>
</div>

<!-- mise ne place de la pagination -->
<div class="d-flex justify-content-between my-4">
    <?php if ($currentPage > 1): ?>
        <!-- on sauvegarde le lien -->
        <?php
        $link = $router->url('home');
        if ($currentPage > 2) $link .= '?page=' . ($currentPage - 1);
        ?>
        <a href="<?= $link ?>" class="btn btn-primary"> &laquo; Page précédente</a>
    <?php endif ?>
    <?php if ($currentPage < $pages): ?>
        <a href="<?= $router->url('home') ?>?page=<?= $currentPage + 1 ?>" class="btn btn-primary ml-auto"> Page
            suivante &raquo;</a>
    <?php endif ?>
</div>