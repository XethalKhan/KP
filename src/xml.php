<?php

namespace KP\SOLID;

use KP\SOLID\Infra\App\App;
use KP\SOLID\Infra\App\DefaultServiceContainerBuilder;
use KP\SOLID\Infra\App\HttpXmlApiRequestActionLoader;
use KP\SOLID\Infra\View\Xml\XmlViewFactory;

require_once 'src/Domain/index.php';
require_once 'src/UseCase/index.php';
require_once 'src/Adapter/index.php';
require_once 'src/Infra/index.php';

$serviceContainerBuilder = new DefaultServiceContainerBuilder();
$actionLoader = new HttpXmlApiRequestActionLoader();
$viewFactory = new XmlViewFactory();

$app = new App($serviceContainerBuilder, $actionLoader, $viewFactory);

$app->execute();