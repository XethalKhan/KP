<?php

namespace KP\SOLID\Infra\View\Xml;

use KP\SOLID\Adapter\BaseViewModel;
use KP\SOLID\Adapter\Core\SignUpErrorViewModel;

class SignUpErrorXmlView extends BaseXmlView{

    public function __construct(BaseViewModel $viewModel){
        parent::__construct($viewModel);
    }

    public function display() : void {
        if(!($this->viewModel instanceof SignUpErrorViewModel)){
            echo 'Unsupported view model';
        }

        parent::display();
        echo "<success>false</success><error>" . $this->viewModel->getMessage() . "</error>";
    }
}