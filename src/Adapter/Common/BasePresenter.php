<?php

namespace KP\SOLID\Adapter;

use KP\SOLID\UseCase\BaseUseCaseOutput;
use KP\SOLID\UseCase\IOutputGateway;
use KP\SOLID\Adapter\BaseViewModel;

class BasePresenter implements IOutputGateway{

    protected $viewModel;

    public function __construct(){

    }

    public function getViewModel() : BaseViewModel {
        return $this->viewModel;
    }

    public function send(BaseUseCaseOutput $input) : void {
        $this->viewModel = $this->viewModelFactoryMethod($input);
    }

    public function viewModelFactoryMethod(BaseUseCaseOutput $input) : BaseViewModel {
        return new EmptyViewModel();
    }
}