<?php

namespace KP\SOLID;

use KP\SOLID\Infra\App\App;
use KP\SOLID\Infra\App\PageServiceContainerBuilder;
use KP\SOLID\Infra\App\HttpHtmlRequestActionLoader;
use KP\SOLID\Infra\View\Page\PageViewFactory;

include 'src\Domain\index.php';
include 'src\UseCase\index.php';
include 'src\Adapter\index.php';
include 'src\Infra\index.php';

$serviceContainerBuilder = new PageServiceContainerBuilder();
$actionLoader = new HttpHtmlRequestActionLoader();
$viewFactory = new PageViewFactory();

$app = new App($serviceContainerBuilder, $actionLoader, $viewFactory);

$app->execute();