<?php

use App\Auth;
use App\Conection;
use App\HTML\Form;
use App\Model\Post;
use App\ObjectHelper;
use App\Table\CategoryTable;
use App\Table\PostTable;
use App\Validators\PostValidator;


Auth::check();

$errors = [];
$pdo = Conection::getPDO();
$post = new Post();

$categoryTable = new CategoryTable($pdo);
//on recuyper les category sous form de liste
$categories = $categoryTable->list();
// on met dans la date du jours dans le champs created_at
$post->setCreatedAt(date('Y-m-d H:i:s'));

//on verifier si y a des donnée poster et on envoye les données
if (!empty($_POST)) {
    $postTable = new PostTable($pdo);

    //on appel la classe PostValidator
    $v = new PostValidator($_POST, $postTable, $post->getID(), $categories);
    //on a importe la class ObjectHelper, et on passe les champs dans un tableau
    ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);
    //on update si nous avons pas d'erreur
    if ($v->validate()) {
        $pdo->beginTransaction();
        $postTable->createPost($post);
        $postTable->attachCategories($post->getID(), $_POST['categories_ids']);
        $pdo->commit();
        header('Location: ' . $router->url('admin_posts'));
        exit();
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($post, $errors)
?>


<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        L'article n'a pas pu etres enregistré, merci de corriger vos erreurs !
    </div>
<?php endif ?>


<h1>Crée un l'article</h1>

<?php require ('_form.php');