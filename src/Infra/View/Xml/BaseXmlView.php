<?php

namespace KP\SOLID\Infra\View\Xml;

use KP\SOLID\Infra\View\BaseView;
use KP\SOLID\Adapter\BaseViewModel;

class BaseXmlView extends BaseView{

    public function __construct(BaseViewModel $viewModel){
        parent::__construct($viewModel);
    }

    public function display() : void {
        header('Content-Type: application/xml');
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
    }
}