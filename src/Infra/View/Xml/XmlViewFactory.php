<?php

namespace KP\SOLID\Infra\View\Xml;

use KP\SOLID\Adapter\BaseViewModel;
use KP\SOLID\Adapter\Core\SignUpErrorViewModel;
use KP\SOLID\Adapter\Core\SignUpSuccessViewModel;
use KP\SOLID\Adapter\ExceptionViewModel;
use KP\SOLID\Infra\View\IViewFactory;
use KP\SOLID\Infra\View\Json\SignUpErrorJsonView;
use KP\SOLID\Infra\View\Json\SignUpSuccessJsonView;

class XmlViewFactory implements IViewFactory {

    public function __construct(){
    }

    public function create(BaseViewModel $viewModel){
        if ($viewModel instanceof ExceptionViewModel) {
            return new ExceptionXmlView($viewModel);
        }

        if ($viewModel instanceof SignUpErrorViewModel) {
            return new SignUpErrorXmlView($viewModel);
        }

        if ($viewModel instanceof SignUpSuccessViewModel) {
            return new SignUpSuccessXmlView($viewModel);
        }
    }

}