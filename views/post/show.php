<?php

use App\Conection;
use App\Table\PostTable;


// on converti l'id en entier
$id = (int)$params['id'];
$slug = $params['slug'];

//on recupere l'ariticle qui conrespond
$pdo = Conection::getPDO();

//on appel la methode find dans le PostTable
$post = (new PostTable($pdo))->find($id);
(new \App\Table\CategoryTable($pdo))->hydratePosts([$post]);

//si le slug de l'url est pas = a celui de l'article alors on returne une erreur
if ($post->getSlug() !== $slug) {
    $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('location:' . $url);
}
?>


<!-- ne pas mettre de html -->
<h1 class="card-title"><?= e($post->getName()) ?></h1>
<!-- on affiche la date et on la formate -->
<p class="text-muted"><?= $post->getCreatedAt()->format('d F Y') ?></p>

<?php foreach ($post->getCategories() as $k => $category):
   if ($k > 0):
        echo ', ';
  endif?>
    <a href="<?= $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()])?>"><?= e($category->getName()) ?></a>
<?php endforeach ?>

<!-- pour repecter les sauts de lignes (nl2br) -->
<p><?= $post->getFormattedContent() ?></p>