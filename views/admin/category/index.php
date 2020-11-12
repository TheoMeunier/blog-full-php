<?php

use App\Auth;
use App\Conection;
use App\Table\CategoryTable;
Auth::check();

$title = "Gestion des categories";
$pdo = Conection::getPDO();

//on definie la variable $link
$link = $router->url('admin_categories');
//on reguper les category
$items = (new CategoryTable($pdo))->all();

?>

<?php if (isset($_GET['delete'])): ?>
<div class="alert alert-success">
    L'enregistrement a bien été supprimer
</div>
<?php endif ?>


<?php if (isset($_GET['created'])): ?>
    <div class="alert alert-success">
        La catégorie a bien ète crée
    </div>
<?php endif ?>

<table class="table">
    <thead>
    <th>id</th>
    <th>Titre</th>
    <th>URL</th>
    <th>
        <a href="<?= $router->url('admin_category_new')?>" class="btn btn-primary">Nouveau</a>
    </th>
    </thead>
    <tbody>
    <?php foreach ($items as $item): ?>
        <tr>
            <td>#<?= $item->getID() ?></td>
            <td>
                <a href="<?= $router->url('admin_category', ['id' => $item->getID()]) ?>">
                    <?= e($item->getName()) ?>
                </a>
            </td>
            <td><?= $item->getSlug() ?></td>
            <td>
                <a href="<?= $router->url('admin_category', ['id' => $item->getID()]) ?>" class="btn btn-primary">
                    Editer
                </a>
                <form action="<?= $router->url('admin_category_delete', ['id' => $item->getID()]) ?>" method="post"
                   onsubmit="return confirm('Voulez vous vraiment effectuer cette action ?')" style="display: inline">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>