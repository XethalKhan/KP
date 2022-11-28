<?php

namespace KP\SOLID\Infra\App;

use Exception;
use KP\SOLID\Adapter\ExceptionViewModel;
use KP\SOLID\Infra\View\IViewFactory;

class App {
    private $serviceContainerBuilder;
    private $actionLoader;
    private $viewFactory;

    public function __construct(BaseServiceContainerBuilder $serviceContainerBuilder, BaseActionLoader $actionLoader, IViewFactory $viewFactory){
        $this->serviceContainerBuilder = $serviceContainerBuilder;
        $this->actionLoader = $actionLoader;
        $this->viewFactory = $viewFactory;
    }

    public function execute(){

        try{
            $serviceContainer = $this->serviceContainerBuilder->build();

            $action = $this->actionLoader->create();

            $executionContext = $serviceContainer->getExecutionContext($action);

            $viewModel = $executionContext->execute($action);

            $view = $this->viewFactory->create($viewModel);

            $view->display();
        } catch(Exception $e){
            $exceptionViewModel = new ExceptionViewModel($e);
            $exceptionView = $this->viewFactory->create($exceptionViewModel);
            $exceptionView->display();
        }
        
    }
}