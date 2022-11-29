<?php

namespace KP\SOLID;

use KP\SOLID\Infra\App\App;
use KP\SOLID\Infra\App\DefaultServiceContainerBuilder;
use KP\SOLID\Infra\App\HttpJsonApiRequestActionLoader;
use KP\SOLID\Infra\View\Json\JsonViewFactory;

require_once 'src/Domain/index.php';
require_once 'src/UseCase/index.php';
require_once 'src/Adapter/index.php';
require_once 'src/Infra/index.php';

$serviceContainerBuilder = new DefaultServiceContainerBuilder();
$actionLoader = new HttpJsonApiRequestActionLoader();
$viewFactory = new JsonViewFactory();

$app = new App($serviceContainerBuilder, $actionLoader, $viewFactory);

$app->execute();