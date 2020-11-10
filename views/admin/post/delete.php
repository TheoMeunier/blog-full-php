<?php

use App\Auth;
use App\Conection;

Auth::check();

$pdo = Conection::getPDO();
$table = new \App\Table\PostTable($pdo);
$table->delete($params['id']);

//on redirige l'utilisateur vers la page precedente
header('location:' . $router->url('admin_posts'). '?delete=1');