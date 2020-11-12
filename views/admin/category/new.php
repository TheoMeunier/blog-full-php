<?php

use App\Conection;
use App\HTML\Form;
use App\Model\Category;
use App\ObjectHelper;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;

$errors = [];
$item = new Category();

//on verifier si y a des donnée poster et on envoye les données
if (!empty($_POST)) {
    $pdo = Conection::getPDO();
    $table = new CategoryTable($pdo);

    //on appel la classe categoryValidator
    $v = new CategoryValidator($_POST, $table);
    //on a importe la class ObjectHelper, et on passe les champs dans un tableau
    ObjectHelper::hydrate($item, $_POST, ['name', 'slug']);
    //on update si nous avons pas d'erreur
    if ($v->validate()) {
        $table->create([
            'name' => $item->getName(),
            'slug' => $item->getSlug()
        ]);
        header('Location: ' . $router->url('admin_categories'));
        exit();
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($item, $errors)
?>


<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        La catégorie n'a pas pu etres enregistré, merci de corriger vos erreurs !
    </div>
<?php endif ?>


<h1>Crée un la catégorie</h1>

<?php require ('_form.php');