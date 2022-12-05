<?php

namespace KP\SOLID\Domain;

class EmptyPredicate extends BasePredicate {
    public function check($input) : bool {
        return true;
    }
}