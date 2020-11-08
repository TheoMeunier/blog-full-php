<?php
use App\Model\Post;

$title = 'Mon blog';

//require_once $_SERVER['DOCUMENT_ROOT'] . "variables.php";
require '../variables.php';

//on ce connecter a la base de donnée
$pdo = new PDO("mysql:dbname=" . DB_NAME . ";host=" . DB_HOST, DB_USERNAME, DB_PASSWORD, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

//on fait la requete sql
$query = $pdo->query('SELECT * FROM post ORDER BY created_at DESC LIMIT 12 ');

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