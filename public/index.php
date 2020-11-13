<?php

// on charger le fichier autoloader
require '../vendor/autoload.php';

define('DEBUG_TIME', microtime(true));

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
$whoops->register();

if (isset($_GET['page']) && $_GET['page'] == '1'){
    //réecrire l'url sans le paramètre page
    $rui = $_SERVER['REQUEST_URI'];
    $url = explode('?', $_SERVER['REQUEST_URI'])['0'];

    //on recupere les paramettre
    $get = $_GET;
    unset($get['page']);

    //on fais la 2eme partie du lien
    $query = http_build_query($get);
    // si query est vide alors on ne touche a rien
    if (!empty($query)){
        $uri = $uri . '?' . $query;
    }
    http_response_code(301);
    header('location' . $uri);
    exit();

}

//on demarre le routeur
/*$router = new AltoRouter();*/

// réorganisation des route
$router = new App\Router(dirname(__DIR__) . '/views');
$router
    ->get('/', 'post/index', 'home')
    ->get('/blog/category/[*:slug]-[i:id]', 'category/show', 'category')
    ->get('/blog/[*:slug]-[i:id]', 'post/show', 'post')
    ->match('/login', 'auth/login', 'login')
    ->post('/logout', 'auth/logout', 'logout')
    //Admin
    //Gestion des article
    ->get('/admin', 'admin/post/index', 'admin_posts')
    ->match('/admin/post/[i:id]', 'admin/post/edit', 'admin_post')
    ->post('/admin/post/[i:id]/delete', 'admin/post/delete', 'admin_post_delete')
    ->match('/admin/post/new', 'admin/post/new', 'admin_post_new')
    //Gestion des catégory
    ->get('/admin/category', 'admin/category/index', 'admin_categories')
    ->match('/admin/category/[i:id]', 'admin/category/edit', 'admin_category')
    ->post('/admin/category/[i:id]/delete', 'admin/category/delete', 'admin_category_delete')
    ->match('/admin/category/new', 'admin/category/new', 'admin_category_new')
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