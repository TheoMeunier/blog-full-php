<?php
namespace App\Table\Exception;


class NotFoundException extends \Exception
{

    public function __contruct(string $table, int $id)
    {
        $this->message= "Aucun enregistrement ne correspond a l'id #$id dans la table '$table'";
    }
}