<?php

use App\Conection;
use App\Table\PostTable;
use App\Validator;

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
    //on lui definir quelque mot en français
    $v = new validator($_POST);
    $v->rule('required', 'name');
    $v->rule('lengthBetween', 'name', 3, 250);
    $post->setName($_POST['name']);
    //on update si nous avons pas d'erreur
    if ($v->validate()) {
        $postTable->update($post);
        $success = true;
    } else {
        $errors = $v->errors();
    }
}
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
    <div class="form-group">
        <label for="name">Titre</label>
        <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" name="name"
               value="<?= e($post->getName()) ?>" required>
        <?php if(isset($errors['name'])): ?>
            <div class="invalid-feedback">
                <?= implode('<br>', $errors['name']) ?>
            </div>
        <?php endif ?>
    </div>
    <button class="btn btn-primary">Modifier</button>
</form>