<?php

use App\Conection;
use App\Model\Category;
use App\Model\Post;
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

//je recupère la page courrante
$currentPage = Url::getPosstiveInt('page', 1);

// si la page <= 0 alors on returne une erreur
if ($currentPage <= 0) {
    throw new Exception('Numéro d epage invalide');
}

//on fait une requete pour compter le nombre d'acticle qu'on a
//et on lui demande recupere les info sous forme de tableau nurmérique
$count = (int)$pdo
    ->query('SELECT COUNT(category_id) FROM post_category WHERE category_id = ' . $category->getID())
    ->fetch(PDO::FETCH_NUM)[0];

//variable pour le nombre de page
$perPage = 12;

// on divise article par page et je recupere le nombre de page
$pages = ceil($count / $perPage);

// si la page la page courrente > au nombre de page alors on returne une exeption
if ($currentPage > $pages) {
    throw new Exception('Cette page n\'existe pas');
}

//on calcule l'offset
$offset = $perPage * ($currentPage - 1);

//on fait la requete sql pour afficher 12 post; je vais faire une liaison
$query = $pdo->query("
    SELECT p.*
    FROM post p
    JOIN post_category pc ON pc.post_id = p.id
    WHERE pc.category_id = {$category->getID()}
    ORDER BY created_at DESC 
    LIMIT $perPage OFFSET $offset
");

//on recupère l'ensemble des article
$posts = $query->fetchAll(PDO::FETCH_CLASS, Post::class);

//on sauvegarde le lien
$link = $router->url('category', ['id' => $category->getID(), 'slug' =>$category->getSLUG()]);

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
    <?php if ($currentPage > 1): ?>
        <!-- on sauvegarde le lien -->
        <?php
        $l = $link;
        if ($currentPage > 2) $l = $link .'?page=' . ($currentPage - 1);
        ?>
        <a href="<?= $l ?>" class="btn btn-primary"> &laquo; Page précédente</a>
    <?php endif ?>
    <?php if ($currentPage < $pages): ?>
        <a href="<?= $link ?>?page=<?= $currentPage + 1 ?>" class="btn btn-primary ml-auto"> Page
            suivante &raquo;</a>
    <?php endif ?>
</div>
