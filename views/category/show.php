<?php

use App\Conection;
use App\Model\Category;
use App\Model\Post;
use App\PaginetedQuery;
use App\Url;

// on converti l'id en entier
$id = (int)$params['id'];
$slug = $params['slug'];

//on recupere l'ariticle qui conrespond
$pdo = Conection::getPDO();
$query = $pdo->prepare('SELECT * FROM category WHERE id = :id');
//on excuse la requete
$query->execute(['id' => $id]);
//on recupere les resultats
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);

// on type la variable
/** @var Category|false */
$category = $query->fetch();

//si aucun resultat est renvoyer alors on revoye une execption
if ($category === false) {
    throw new Exception("Aucun catégorie ne correspond a cette article");
}

//si le slug de l'url est pas = a celui de l'article alors on returne une erreur
if ($category->getSlug() !== $slug) {
    $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('location:' . $url);
}

//on défini le titre
$title = "Catégorie {$category->getName()}";

//on défini le constructeur
$paginatedQuery = new PaginetedQuery(
"SELECT p.*
            FROM post p
            JOIN post_category pc ON pc.post_id = p.id
            WHERE pc.category_id = {$category->getID()}
            ORDER BY created_at DESC ",
"SELECT COUNT(category_id) FROM post_category WHERE category_id = {$category->getID()}",
            Post::class
);

/** @var Psot[] */
//on recupére l'ensemble des èlements
$posts= $paginatedQuery->getItems();
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
