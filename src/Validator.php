<?php

namespace App;

use Valitron\Validator as ValitronValidatorr;

class Validator extends ValitronValidatorr
{
    protected function checkAndSetLabel($field, $message, $params)
    {
            return str_replace('{field}', '', $message);
    }
}