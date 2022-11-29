<?php

namespace KP\SOLID;

use KP\SOLID\Infra\App\App;
use KP\SOLID\Infra\App\DefaultServiceContainerBuilder;
use KP\SOLID\Infra\App\HttpXmlApiRequestActionLoader;
use KP\SOLID\Infra\View\Xml\XmlViewFactory;

include 'src\Domain\index.php';
include 'src\UseCase\index.php';
include 'src\Adapter\index.php';
include 'src\Infra\index.php';

$serviceContainerBuilder = new DefaultServiceContainerBuilder();
$actionLoader = new HttpXmlApiRequestActionLoader();
$viewFactory = new XmlViewFactory();

$app = new App($serviceContainerBuilder, $actionLoader, $viewFactory);

$app->execute();