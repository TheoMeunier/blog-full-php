<?php

use App\Conection;
use App\Table\CategoryTable;
use App\Table\PostTable;

// on converti l'id en entier
$id = (int)$params['id'];
$slug = $params['slug'];

//on recupere l'ariticle qui conrespond
$pdo = Conection::getPDO();
$category = (new CategoryTable($pdo))->find($id);

//si le slug de l'url est pas = a celui de l'article alors on returne une erreur
if ($category->getSlug() !== $slug) {
    $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('location:' . $url);
}

//on défini le titre
$title = "Catégorie {$category->getName()}";

//on appel les methodes
[$posts, $paginatedQuery] = (new PostTable($pdo))->findPaginatedForCategory($category->getID());


//on sauvegarde le lien
$link = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSLUG()]);
?>

<h1><?= e($title) ?></h1>

<div class="row">
    <?php foreach ($posts as $post): ?>
        <div class="col-md-3 mb-3">
            <!--on importe le fichier card.php-->
            <?php require dirname(__DIR__) . '/post/card.php' ?>
        </div>
    <?php endforeach ?>
</div>

<!-- mise ne place de la pagination -->
<div class="d-flex justify-content-between my-4">
    <!-- on affiche le lien précédent et on passe le lien qu'on recupere dans le routeur  -->
    <?= $paginatedQuery->previousLink($link) ?>
    <?= $paginatedQuery->nextLink($link) ?>
</div>
