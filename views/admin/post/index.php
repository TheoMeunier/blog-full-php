<?php

use App\Auth;
use App\Conection;
use App\Table\PostTable;

Auth::check();

$title = "Administration";
$pdo = Conection::getPDO();

//on definie la variable $link
$link = $router->url('admin_posts');
//on affiche les post
[$posts, $pagination] = (new PostTable($pdo))->findPaginated();

?>

<?php if (isset($_GET['delete'])): ?>
<div class="alert alert-success">
    L'enregistrement a bien été supprimer
</div>
<?php endif ?>

<?php if (isset($_GET['create'])): ?>
<div class="alert alert-success">
    L'enregistrement a bien été supprimer
</div>
<?php endif ?>

<table class="table">
    <thead>
    <th>id</th>
    <th>Titre</th>
    <th>
        <a href="<?= $router->url('admin_post_new')?>" class="btn btn-primary">Nouveau</a>
    </th>
    </thead>
    <tbody>
    <?php foreach ($posts as $post): ?>
        <tr>
            <td>#<?= $post->getID() ?></td>
            <td>
                <a href="<?= $router->url('admin_post', ['id' => $post->getID()]) ?>">
                    <?= e($post->getName()) ?>
                </a>
            </td>
            <td>
                <a href="<?= $router->url('admin_post', ['id' => $post->getID()]) ?>" class="btn btn-primary">
                    Editer
                </a>
                <form action="<?= $router->url('admin_post_delete', ['id' => $post->getID()]) ?>" method="post"
                   onsubmit="return confirm('Voulez vous vraiment effectuer cette action ?')" style="display: inline">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>


<!-- mise ne place de la pagination -->
<div class="d-flex justify-content-between my-4">
    <!-- on affiche le lien précédent et on passe le lien qu'on recupere dans le routeur  -->
    <?= $pagination->previousLink($link) ?>
    <?= $pagination->nextLink($link) ?>
</div>