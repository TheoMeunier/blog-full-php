<?php

use App\Conection;
use App\HTML\Form;
use App\ObjectHelper;
use App\Table\PostTable;
use App\Validators\PostValidator;

$pdo = Conection::getPDO();
$postTable = new PostTable($pdo);
//on genere l'article
$post = $postTable->find($params['id']);
$success = false;

$errors = [];

//on verifier si y a des donnée poster et on envoye les données
if (!empty($_POST)) {
    //on appel la classe PostValidator
    $v = new PostValidator($_POST, $postTable, $post->getID());

    //on a importe la class ObjectHelper, et on passe les champs dans un tableau
    ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);
    //on update si nous avons pas d'erreur
    if ($v->validate()) {
        $postTable->update($post);
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

<?php if (isset($_GET['created'])): ?>
    <div class="alert alert-success">
        L'article a bien ète crée
    </div>
<?php endif ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        L'article n'a pas pu etres modifié, merci de corriger vos erreurs !
    </div>
<?php endif ?>


<h1>Editer l'article <?= e($post->getName()) ?></h1>


<?php require ('_form.php');