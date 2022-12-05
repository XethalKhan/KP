<?php

namespace KP\SOLID\Domain;

abstract class BasePredicate {
    public abstract function check($input) : bool;
}