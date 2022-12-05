<?php

namespace KP\SOLID;

use KP\SOLID\Adapter\ExceptionViewModel;
use KP\SOLID\Infra\App\App;
use KP\SOLID\Infra\App\PageServiceContainerBuilder;
use KP\SOLID\Infra\App\HttpHtmlRequestActionLoader;
use KP\SOLID\Infra\Logger\FileLogger;
use KP\SOLID\Infra\View\Page\PageViewFactory;
use Throwable;

function html_exception_handler(Throwable $exception) {
    $logger = new FileLogger();
    $viewFactory = new PageViewFactory();
    $logger->error($exception->getMessage());
    $logger->error("Stack trace:\n" . $exception->getTraceAsString());
    $exceptionViewModel = new ExceptionViewModel($exception);
    $exceptionView = $viewFactory->create($exceptionViewModel);
    $exceptionView->display();
}
  
set_exception_handler('KP\SOLID\html_exception_handler');

$serviceContainerBuilder = new PageServiceContainerBuilder();
$actionLoader = new HttpHtmlRequestActionLoader();
$viewFactory = new PageViewFactory();

$app = new App($serviceContainerBuilder, $actionLoader, $viewFactory);

$app->execute();