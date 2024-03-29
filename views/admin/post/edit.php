<?php

use App\Auth;
use App\Conection;
use App\HTML\Form;
use App\ObjectHelper;
use App\Table\CategoryTable;
use App\Table\PostTable;
use App\Validators\PostValidator;


Auth::check();


$pdo = Conection::getPDO();
$postTable = new PostTable($pdo);
$categoryTable = new CategoryTable($pdo);
//on recuyper les category sous form de liste
$categories = $categoryTable->list();
//on genere l'article
$post = $postTable->find($params['id']);
$categoryTable->hydratePosts([$post]);
$success = false;

$errors = [];

//on verifier si y a des donnée poster et on envoye les données
if (!empty($_POST)) {
    //on appel la classe PostValidator
    $v = new PostValidator($_POST, $postTable, $post->getID(), $categories);

    //on a importe la class ObjectHelper, et on passe les champs dans un tableau
    ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);
    //on update si nous avons pas d'erreur
    if ($v->validate()) {
        $pdo->beginTransaction();
        $postTable->updatePost($post);
        $postTable->attachCategories($post->getID(), $_POST['categories_ids']);
        $pdo->commit();
        $categoryTable->hydratePosts([$post]);
        $success = true;
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($post, $errors)
?>


<?php if ($success): ?>
    <div class="alert alert-success">
        L'article a bien ète modifier
    </div>
<?php endif ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        L'article n'a pas pu etres modifié, merci de corriger vos erreurs !
    </div>
<?php endif ?>


<h1>Editer l'article <?= e($post->getName()) ?></h1>


<?php require ('_form.php');