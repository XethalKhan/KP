<?php

namespace KP\SOLID;

use KP\SOLID\Infra\App\App;
use KP\SOLID\Infra\App\PageServiceContainerBuilder;
use KP\SOLID\Infra\App\HttpHtmlRequestActionLoader;
use KP\SOLID\Infra\View\Page\PageViewFactory;

require_once 'src/Domain/index.php';
require_once 'src/UseCase/index.php';
require_once 'src/Adapter/index.php';
require_once 'src/Infra/index.php';

$serviceContainerBuilder = new PageServiceContainerBuilder();
$actionLoader = new HttpHtmlRequestActionLoader();
$viewFactory = new PageViewFactory();

$app = new App($serviceContainerBuilder, $actionLoader, $viewFactory);

$app->execute();