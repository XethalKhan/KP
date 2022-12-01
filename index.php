<?php
set_error_handler(function($errno, $errstr, $errfile, $errline ){
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});

require_once 'src/Domain/index.php';
require_once 'src/UseCase/index.php';
require_once 'src/Adapter/index.php';
require_once 'src/Infra/index.php';

if(!isset($_SERVER['CONTENT_TYPE'])){
    require_once 'src/html.php';
} else if($_SERVER['CONTENT_TYPE'] === 'application/json'){
    require_once 'src/json.php';
} else if($_SERVER['CONTENT_TYPE'] === 'application/xml'){
    require_once 'src/xml.php';
} else {
    require_once 'src/html.php';
}
