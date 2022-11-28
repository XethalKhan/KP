<?php

namespace KP\SOLID\Infra\View\Json;

use KP\SOLID\Adapter\BaseViewModel;
use KP\SOLID\Adapter\Core\SignUpErrorViewModel;

class SignUpErrorJsonView extends BaseJsonView{

    public function __construct(BaseViewModel $viewModel){
        parent::__construct($viewModel);
    }

    public function display() : void {
        if(!($this->viewModel instanceof SignUpErrorViewModel)){
            echo 'Unsupported view model';
        }

        parent::display();

        echo "{\"success\": false, \"error\": \"" . $this->viewModel->getMessage() . "\"}";
    }
}