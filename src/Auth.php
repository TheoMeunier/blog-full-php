<?php
namespace App;


use App\Security\ForbiddenExecption;

class Auth
{
    //on verifie si l'utilisateur est bien administrateur
    public static function check()
    {
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if (!isset($_SESSION['auth'])){
            throw new ForbiddenExecption();
        }
    }
}