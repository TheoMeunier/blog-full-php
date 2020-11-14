<?php

namespace App;

use Valitron\Validator as ValitronValidatorr;

class Validator extends ValitronValidatorr
{
    //on defini les regles en fr
    protected static $_lang = "fr";

    protected function checkAndSetLabel($field, $message, $params)
    {
            return str_replace('{field}', '', $message);
    }
}