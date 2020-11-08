<?php
namespace App\Helpers;

class Text{


    //coupe le text a 60 caractère et on met ...
    public static function excerpt(string $content, int $limit = 60)
    {
        if (mb_strlen($content) <= $limit){
            return $content;
        }
        //on recupère la position de l'espace apres la limite
        $lastSpace = mb_strpos($content, ' ', $limit);

        //on mettre 3 petits points apres la limit
        return mb_substr($content, 0, $lastSpace ). '...' ;
    }
}