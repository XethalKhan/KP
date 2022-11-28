<?php

namespace KP\SOLID;

use KP\SOLID\Infra\App\App;
use KP\SOLID\Infra\App\DefaultServiceContainerBuilder;
use KP\SOLID\Infra\App\HttpJsonApiRequestActionLoader;
use KP\SOLID\Infra\View\Json\JsonViewFactory;

include 'src\Domain\index.php';
include 'src\UseCase\index.php';
include 'src\Adapter\index.php';
include 'src\Infra\index.php';

$serviceContainerBuilder = new DefaultServiceContainerBuilder();
$actionLoader = new HttpJsonApiRequestActionLoader();
$viewFactory = new JsonViewFactory();

$app = new App($serviceContainerBuilder, $actionLoader, $viewFactory);

$app->execute();