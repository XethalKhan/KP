<?php

namespace KP\SOLID\Infra\View\Json;

use KP\SOLID\Infra\View\BaseView;
use KP\SOLID\Adapter\BaseViewModel;

class BaseJsonView extends BaseView{

    public function __construct(BaseViewModel $viewModel){
        parent::__construct($viewModel);
    }

    public function display() : void {
        header('Content-Type: application/json');
    }
}