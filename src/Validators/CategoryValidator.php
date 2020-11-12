<?php
namespace App\Validators;

use App\Table\CategoryTable;

class CategoryValidator extends AbstractValidator
{

    public function __construct(array $data, CategoryTable $table, ?int $id = null)
    {
        //on mon AbstractValidator
        parent::__construct($data);
        //on ajoutes de regle a la validation
        $this->validator->rule('required', ['name', 'slug']);
        $this->validator->rule('lengthBetween', ['name', 'slug'], 3, 250);
        $this->validator->rule('slug', 'slug');
        //on crée une fonction pour ne pas avoir le meme slug sur plusieurs article
        $this->validator->rule(function ($field, $value) use($table, $id){
            return !$table->existe($field, $value, $id);
        }, 'slug', 'ce slug est déjà utiliser');
    }


}