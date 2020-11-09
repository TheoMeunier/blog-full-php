<?php
namespace App;

class Url
{

    //on le nombre dans l'url est pas dans entier alors on returne une erreur
    public static function getInt(string $name, ?int $default = null): ?int
    {
        //on vérifie si getPage exist
        if (!isset($_GET[$name])) return $default;

        if ($_GET[$name] === '0')return 0;

        //si le numéro de page n'est pas valide alors on lui returne une erreur
        if (!filter_var($_GET[$name], FILTER_VALIDATE_INT)) {
            throw new \Exception("Le paramètre '$name'dans l'url n'est pas un entier");
        }
        return (int)$_GET[$name];
    }


    // si le parametre dans l'url est positif alors on return une erreur
    public static function getPosstiveInt(string $name, ?int $defaut = null): ?int
    {
        $param = self::getInt($name, $defaut);

        if ($param !== null && $param <= 0){
            throw new \Exception("Le paramètre  '$name'dans l'url n'est pas un entier positif");
        }
        return $param;
    }
}