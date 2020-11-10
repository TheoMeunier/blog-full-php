<?php

use App\Model\Post;
use App\Conection;
use App\PaginetedQuery;
use App\Url;

$title = 'Mon blog';

//on ce connecter a la base de donnée
$pdo = Conection::getPDO();

//on génére notre paginatedQuery
$paginatedQuery = new PaginetedQuery(
        "SELECT * FROM post ORDER BY created_at DESC",
    //on lui passe la requete pour compte les pages
    "SELECT COUNT(id) FROM post",
);

//on recupère les 12 dernière données
$posts = $paginatedQuery->getItems(Post::class);
//on génère le liens
$link = $router->url('home');

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
    <!-- on affiche le lien précédent et on passe le lien qu'on recupere dans le routeur  -->
    <?= $paginatedQuery->previousLink($link) ?>
    <?= $paginatedQuery->nextLink($link) ?>
</div>