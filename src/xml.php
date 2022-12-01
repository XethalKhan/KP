<?php

namespace KP\SOLID;

use KP\SOLID\Adapter\ExceptionViewModel;
use KP\SOLID\Infra\App\App;
use KP\SOLID\Infra\App\DefaultServiceContainerBuilder;
use KP\SOLID\Infra\App\HttpXmlApiRequestActionLoader;
use KP\SOLID\Infra\Logger\FileLogger;
use KP\SOLID\Infra\View\Xml\XmlViewFactory;
use Throwable;

function xml_exception_handler(Throwable $exception) {
    $logger = new FileLogger();
    $viewFactory = new XmlViewFactory();
    $logger->error($exception->getMessage());
    $logger->error("Stack trace:\n" . $exception->getTraceAsString());
    $exceptionViewModel = new ExceptionViewModel($exception);
    $exceptionView = $viewFactory->create($exceptionViewModel);
    $exceptionView->display();
}
  
set_exception_handler('KP\SOLID\xml_exception_handler');

$serviceContainerBuilder = new DefaultServiceContainerBuilder();
$actionLoader = new HttpXmlApiRequestActionLoader();
$viewFactory = new XmlViewFactory();

$app = new App($serviceContainerBuilder, $actionLoader, $viewFactory);

$app->execute();