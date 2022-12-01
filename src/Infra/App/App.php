<?php

namespace KP\SOLID\Infra\App;

use ErrorException;
use Exception;
use KP\SOLID\Adapter\ExceptionViewModel;
use KP\SOLID\Infra\Logger\FileLogger;
use KP\SOLID\Infra\View\IViewFactory;
use KP\SOLID\UseCase\ConfigurationException;
use KP\SOLID\UseCase\LoggerException;

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
            if($e instanceof LoggerException || $e instanceof ConfigurationException || $e instanceof ServiceContainerException || $e instanceof ErrorException){
                $logger = new FileLogger();
            }else{
                $logger = $serviceContainer->getLogger();
            }
            $logger->error($e->getMessage());
            $logger->error("Stack trace:\n" . $e->getTraceAsString());
            $exceptionViewModel = new ExceptionViewModel($e);
            $exceptionView = $this->viewFactory->create($exceptionViewModel);
            $exceptionView->display();
        }
        
    }
}