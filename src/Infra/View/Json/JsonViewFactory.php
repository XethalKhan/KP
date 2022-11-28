<?php

namespace KP\SOLID\Infra\View\Json;

use KP\SOLID\Adapter\BaseViewModel;
use KP\SOLID\Adapter\Core\SignUpErrorViewModel;
use KP\SOLID\Adapter\Core\SignUpSuccessViewModel;
use KP\SOLID\Adapter\ExceptionViewModel;
use KP\SOLID\Infra\View\IViewFactory;
use KP\SOLID\Infra\View\Json\SignUpErrorJsonView;
use KP\SOLID\Infra\View\Json\SignUpSuccessJsonView;

class JsonViewFactory implements IViewFactory {

    public function __construct(){
    }

    public function create(BaseViewModel $viewModel){
        if ($viewModel instanceof ExceptionViewModel) {
            return new ExceptionJsonView($viewModel);
        }

        if ($viewModel instanceof SignUpErrorViewModel) {
            return new SignUpErrorJsonView($viewModel);
        }

        if ($viewModel instanceof SignUpSuccessViewModel) {
            return new SignUpSuccessJsonView($viewModel);
        }
    }

}