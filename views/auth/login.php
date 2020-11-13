<?php

use App\Conection;
use App\HTML\Form;
use App\Model\User;
use App\Table\Exception\NotFoundException;
use App\Table\UserTable;

//on crée un nouvelle utilisateur
$user = new User();
//on crée un tableau qui contient les erreurs
$errors = [];

if (!empty($_POST)){
    //on sauvegarde sur le username
    $user->setUsername($_POST['username']);
    $errors['password'] = 'Identifiant ou mot de passe incorrecte';
    //on vérifie si les champs sont remplie
    if (!empty($_POST['username']) || !empty($_POST['password'])){
        $table= new UserTable(Conection::getPDO());
    try {
        //on lui demande de chercher l'utiliateur qui a ecrit son nom d'utilisateur
        $u = $table->findByUsername($_POST['username']);
        if (password_verify($_POST['password'], $u->getPassword()) === true){
            session_start();
            $_SESSION['auth'] = $u->getID();
            header('Location: ' . $router->url('admin_posts'));
            exit();
        }
    }catch (NotFoundException $e){
    }
    }
}

//on crée un nouveau formulaire
$form =  new Form($user, $errors);

?>

<?php if (isset($_GET['forbidden'])): ?>
<div class="alert alert-danger">
    Vous ne pouvez pas accéder à cette page
</div>
<?php endif ?>


<h1>Se connecter</h1>

<form action="<?= $router->url('login') ?>" method="POST">
        <?= $form->input('username', "Nom d'utilisateur") ?>
        <?= $form->input('password', "Mot de passe") ?>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>
