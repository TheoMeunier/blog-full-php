<?php
namespace App\Validators;

use App\Validator;

abstract class AbstractValidator
{

    protected $data;
    protected $validator;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->validator = new  Validator($data);
    }

    // on definie la validation qui revoyer 0 ou 1
    public function validate(): bool
    {
        //on recupere la validation
        return $this->validator->validate();
    }

    public function errors(): array
    {
        //on recupere la liste des erreurs
        return $this->validator->errors();
    }
}