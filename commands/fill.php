<?php

use App\Conection;

require_once $_SERVER['DOCUMENT_ROOT'] . "variables.php";

require dirname(__DIR__). '/vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

//on ce connecter a la base de donnée
$pdo = Conection::getPDO();

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('TRUNCATE TABLE users');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

$posts = [];
$categories = [];

// on génére des posts
for ($i = 0; $i < 50; $i++) {
    $pdo->exec("INSERT INTO post SET name='{$faker->sentence()}' , slug='{$faker->slug}' , created_at='{$faker->date} {$faker->time}' , content='{$faker->paragraphs(rand(3 ,15), true)}'");
    //on recupere l'id du dernier enregistrement
    $posts[] = $pdo->lastInsertId();
}

// on génére des category
for ($i = 0; $i < 5; $i++) {
    $pdo->exec("INSERT INTO category SET name='{$faker->sentence(3)}' , slug='{$faker->slug}'");
    $categories[] = $pdo->lastInsertId();
}

//on crée les liaison pour liée les donner entre elles
foreach ($posts as $post){
    $randomCategories = $faker->randomElements($categories, rand(0, count($categories)));
    foreach ($randomCategories as $category){
        $pdo->exec("INSERT INTO post_category SET post_id=$post , category_id=$category ");
    }
}

//on hache le mdp
$password = password_hash('admin', PASSWORD_BCRYPT);

//on genere les utilisateurs
$pdo->exec("INSERT INTO users SET username='admin', password='$password'");