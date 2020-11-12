<?php

use App\Auth;
use App\Conection;
use App\HTML\Form;
use App\ObjectHelper;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;


Auth::check();


$pdo = Conection::getPDO();
$table = new CategoryTable($pdo);
//on genere l'article
$item = $table->find($params['id']);
$success = false;

$errors = [];
//liste des champs
$fields = ['name', 'slug'];

//on verifier si y a des donnée poster et on envoye les données
if (!empty($_POST)) {
    //on appel la classe PostValidator
    $v = new CategoryValidator($_POST, $table, $item->getID());

    //on a importe la class ObjectHelper, et on passe les champs dans un tableau
    ObjectHelper::hydrate($item, $_POST, $fields);
    //on update si nous avons pas d'erreur
    if ($v->validate()) {
        $table->update([
                'name' => $item->getName(),
                'slug' => $item->getSlug()
        ], $item->getID());
        $success = true;
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($item, $errors)
?>


<?php if ($success): ?>
    <div class="alert alert-success">
        La catégorie a bien ète modifier
    </div>
<?php endif ?>

<?php if (isset($_GET['created'])): ?>
    <div class="alert alert-success">
        La catégorie a bien ète crée
    </div>
<?php endif ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        La catégorie n'a pas pu etres modifiée, merci de corriger vos erreurs !
    </div>
<?php endif ?>


<h1>Editer la catégorie <?= e($item->getName()) ?></h1>


<?php require ('_form.php');