<?php

namespace KP\SOLID\Domain;

use InvalidArgumentException;

class ValidatePasswordFormatPredicate extends BasePredicate {
    public function check($input) : bool {
        if(!is_string($input)){
            throw new InvalidArgumentException("Predicate ". __CLASS__ . " does not support operation on input " . gettype($input) . ".");
        }

        if (empty($input) || mb_strlen($input) < 8){
            return false;
        }

        return true;
    }
}