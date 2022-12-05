<?php

namespace KP\SOLID\Infra\View\Json;

use KP\SOLID\Adapter\BaseViewModel;
use KP\SOLID\Adapter\Core\SignUpSuccessViewModel;

class SignUpSuccessJsonView extends BaseJsonView{

    public function __construct(BaseViewModel $viewModel){
        parent::__construct($viewModel);
    }

    public function display() : void {
        if(!($this->viewModel instanceof SignUpSuccessViewModel)){
            echo 'Unsupported view model';
        }

        parent::display();
        
        echo "{\"success\": true, \"userId\": \"" . $this->viewModel->getID() . "\"}";
    }
}