<?php

use App\Auth;
use App\Conection;

Auth::check();

$pdo = Conection::getPDO();
$table = new \App\Table\CategoryTable($pdo);
$table->delete($params['id']);

//on redirige l'utilisateur vers la page precedente
header('location:' . $router->url('admin_categories'). '?delete=1');