<?php
use App\Model\Post;

$title = 'Mon blog';

//require_once $_SERVER['DOCUMENT_ROOT'] . "variables.php";
require '../variables.php';

//on ce connecter a la base de donnée
$pdo = new PDO("mysql:dbname=" . DB_NAME . ";host=" . DB_HOST, DB_USERNAME, DB_PASSWORD, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// on defini le numério de la page en entier dans l'url
$page = $_GET['page'] ?? 1;

//si le numéro de page n'est pas valide alors on lui returne une erreur
if (!filter_var($page, FILTER_VALIDATE_INT)){
    throw new Exception('Numéro d epage invalide');
}

//si dans l'url page=1 alors on ne met rien
if ($page === '1'){
    header('Location :' . $router->url('home'));
    http_response_code(301);
    exit();
}

//numéro de la page courrante, la page par defaut est 1
$currentPage = (int)$page;

// si la page <= 0 alors on returne une erreur
if ($currentPage <= 0){
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
if ($currentPage > $pages){
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

<!-- mise ne plage de la pagination -->
<div class="d-flex justify-content-between my-4">
    <?php if ($currentPage >1 ): ?>
        <!-- on sauvegarde le lien -->
        <?php
            $link = $router->url('home');
            if($currentPage > 2 ) $link .= '?page=' . ($currentPage -1);
        ?>
        <a href="<?= $link ?>" class="btn btn-primary">Page précédente</a>
    <?php endif ?>
    <?php if ($currentPage < $pages ): ?>
        <a href="<?= $router->url('home')?>?page=<?= $currentPage + 1 ?>" class="btn btn-primary ml-auto">Page suivante</a>
    <?php endif ?>
</div>