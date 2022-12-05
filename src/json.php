<?php

namespace KP\SOLID;

use KP\SOLID\Adapter\ExceptionViewModel;
use KP\SOLID\Infra\App\App;
use KP\SOLID\Infra\App\DefaultServiceContainerBuilder;
use KP\SOLID\Infra\App\HttpJsonApiRequestActionLoader;
use KP\SOLID\Infra\Logger\FileLogger;
use KP\SOLID\Infra\View\Json\JsonViewFactory;
use Throwable;

function json_exception_handler(Throwable $exception) {
    $logger = new FileLogger();
    $viewFactory = new JsonViewFactory();
    $logger->error($exception->getMessage());
    $logger->error("Stack trace:\n" . $exception->getTraceAsString());
    $exceptionViewModel = new ExceptionViewModel($exception);
    $exceptionView = $viewFactory->create($exceptionViewModel);
    $exceptionView->display();
}
  
set_exception_handler('KP\SOLID\json_exception_handler');

$serviceContainerBuilder = new DefaultServiceContainerBuilder();
$actionLoader = new HttpJsonApiRequestActionLoader();
$viewFactory = new JsonViewFactory();

$app = new App($serviceContainerBuilder, $actionLoader, $viewFactory);

$app->execute();