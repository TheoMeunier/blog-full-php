<?php

use App\Conection;
use App\Model\Category;
use App\Model\Post;


// on converti l'id en entier
$id = (int)$params['id'];
$slug = $params['slug'];

//on recupere l'ariticle qui conrespond
$pdo = Conection::getPDO();
$query = $pdo->prepare('SELECT * FROM post WHERE id = :id');
//on excuse la requete
$query->execute(['id' => $id]);
//on recupere les resultats
$query->setFetchMode(PDO::FETCH_CLASS, Post::class);

// on type la variable
/** @var Post|false */
$post = $query->fetch();

//si aucun resultat est renvoyer alors on revoye une execption
if ($post === false) {
    throw new Exception("Aucun article ne correspond a cette article");
}

//si le slug de l'url est pas = a celui de l'article alors on returne une erreur
if ($post->getSlug() !== $slug) {
    $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('location:' . $url);
}

//on recupere les category
//on change la requete sql
$query = $pdo->prepare('
SELECT c.id, c.slug, c.name 
FROM post_category pc 
JOIN category c ON pc.category_id = c.id
WHERE pc.post_id = :id');

$query->execute(['id' => $post->getId()]);
//on recupere les info
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);
/** @var Category[] */
$categories = $query->fetchAll()
?>


<!-- ne pas mettre de html -->
<h1 class="card-title"><?= e($post->getName()) ?></h1>
<!-- on affiche la date et on la formate -->
<p class="text-muted"><?= $post->getCreatedAt()->format('d F Y') ?></p>

<?php foreach ($categories as $k => $category):
   if ($k > 0):
        echo ', ';
  endif?>
    <a href="<?= $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()])?>"><?= e($category->getName()) ?></a>
<?php endforeach ?>

<!-- pour repecter les sauts de lignes (nl2br) -->
<p><?= $post->getFormattedContent() ?></p>