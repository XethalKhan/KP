<?php

namespace KP\SOLID\Infra\View\Xml;

use KP\SOLID\Adapter\BaseViewModel;
use KP\SOLID\Adapter\Core\SignUpSuccessViewModel;

class SignUpSuccessXmlView extends BaseXmlView{

    public function __construct(BaseViewModel $viewModel){
        parent::__construct($viewModel);
    }

    public function display() : void {
        if(!($this->viewModel instanceof SignUpSuccessViewModel)){
            echo 'Unsupported view model';
        }

        parent::display();
        
        echo "<success>true</success><userId>" . $this->viewModel->getID() . "</userId>";
    }
}