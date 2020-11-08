<?php

// on charger le fichier autoloader
require '../vendor/autoload.php';

define('DEBUG_TIME', microtime(true));

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
$whoops->register();

//on demarre le routeur
/*$router = new AltoRouter();*/

// réorganisation des route
$router = new App\Router(dirname(__DIR__) . '/views');
$router
    ->get('/', 'post/index', 'home')
    ->get('/blog/[*:slug]-[i:id]', 'post/show', 'post')
    ->get('/blog/category', 'category/show', 'category')
    ->run();

/*
//constante vers le chemain des vus
define('VIEW_PATH',  dirname(__DIR__) . '/views');

//on géner notre premiere url
$router->map('GET', '/blog', function(){
    require VIEW_PATH . '/post/index.php';
} );
$router->map('GET', '/blog/category', function(){
    require VIEW_PATH . '/category/show.php';
} );

// on demande au routeur si l'url taper correspond a ces routes
$match = $router->match();
$match['target']();
*/