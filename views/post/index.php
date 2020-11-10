<?php

use App\Conection;
use App\Table\PostTable;

$title = 'Mon blog';
//on ce connecter a la base de donnée
$pdo = Conection::getPDO();

//on appele la fonction dans notre controller
$table = new PostTable($pdo);
// on recupere les elements de la fonctions du tableau
[$posts, $pagination] = $table->findPaginated();


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
    <?= $pagination->previousLink($link) ?>
    <?= $pagination->nextLink($link) ?>
</div>