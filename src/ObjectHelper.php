<?php


namespace App;


class ObjectHelper
{
    public static function hydrate($object, array $data, array $fields): void
    {
        //on parcour l'ensemble de mes champs
        foreach ($fields as $field){
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));
            //on dit a notre ojet d'appel la method
            $object->$method($data[$field]);
        }
    }
}