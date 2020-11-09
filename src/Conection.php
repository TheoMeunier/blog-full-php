<?php
namespace App;

use PDO;

class Conection
{

    public static function getPDO(): \PDO
    {
        //on importe le fichier de la variable
        require '../variables.php';

        //on ce connecter a la base de donnée
        return new PDO("mysql:dbname=" . DB_NAME . ";host=" . DB_HOST, DB_USERNAME, DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}