<?php

use App\Conection;
use App\HTML\Form;
use App\Table\PostTable;
use App\Validator;
use App\Validators\PostValidator;

$pdo = Conection::getPDO();
$postTable = new PostTable($pdo);
//on genere l'article
$post = $postTable->find($params['id']);
$success = false;

$errors = [];

//on verifier si y a des donnée poster et on envoye les données
if (!empty($_POST)) {
    //on lui demande de passer les message en français
    Validator::lang('fr');
    //on appel la classe PostValidator
    $v = new PostValidator($_POST, $postTable, $post->getID());

    $post
        ->setName($_POST['name'])
        ->setContent($_POST['content'])
        ->setSlug($_POST['slug'])
        ->setCreatedAt($_POST['created_at']);
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

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        L'article n'a pas pu etres modifié, merci de corriger vos erreurs !
    </div>
<?php endif ?>


<h1>Editer l'article <?= e($post->getName()) ?></h1>

<form action="" method="POST">
    <?=  $form->input('name', 'Titre'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <?= $form->textarea('content', 'Contenu'); ?>
    <?= $form->input('created_at', 'Date de création'); ?>
    <button class="btn btn-primary">Modifier</button>
</form>