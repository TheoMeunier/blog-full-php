<?php
namespace App\Validators;

use App\Table\PostTable;

class PostValidator extends AbstractValidator
{

    public function __construct(array $data, PostTable $table, ?int $postID = null, array $categories)
    {
        //on mon AbstractValidator
        parent::__construct($data);
        //on ajoutes de regle a la validation
        $this->validator->rule('required', ['name', 'slug']);
        $this->validator->rule('lengthBetween', ['name', 'slug'], 3, 250);
        $this->validator->rule('slug', 'slug');
        $this->validator->rule('subset',  'categories_ids', array_keys($categories));
        //on crée une fonction pour ne pas avoir le meme slug sur plusieurs article
        $this->validator->rule(function ($field, $value) use($table, $postID){
            return !$table->existe($field, $value, $postID);
        }, 'slug', 'ce slug est déjà utiliser');
    }


}