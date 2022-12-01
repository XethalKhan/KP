<?php

namespace KP\SOLID\Infra\App;

use KP\SOLID\Adapter\BaseAction;
use KP\SOLID\Adapter\BaseController;
use KP\SOLID\Adapter\BasePresenter;
use KP\SOLID\Adapter\BaseViewModel;

class ExecutionContext {

    protected $controller;
    protected $presenter;

    public function __construct(BaseController $controller, BasePresenter $presenter) {
        $this->controller = $controller;
        $this->presenter = $presenter;
    }

    public function execute(BaseAction $action) : BaseViewModel {
        $this->controller->execute($action);

        return $this->presenter->getViewModel();
    }
}