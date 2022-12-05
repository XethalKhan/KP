<?php

namespace KP\SOLID\Infra\View;

use KP\SOLID\Adapter\BaseViewModel;
use KP\SOLID\Adapter\EmptyViewModel;

class BaseView{

    protected $viewModel;

    public function __construct(BaseViewModel $viewModel){
        $this->viewModel = $viewModel;
    }

    public function display() : void {
        if($this->viewModel instanceof EmptyViewModel){
            echo '';
        }
    }
}