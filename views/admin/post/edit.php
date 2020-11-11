<?php

use App\Conection;
use App\Table\PostTable;

$pdo = Conection::getPDO();
$postTable = new PostTable($pdo);
//on genere l'article
$post = $postTable->find($params['id']);
?>

<h1>Editer l'article <?= e($post->getName())?></h1>