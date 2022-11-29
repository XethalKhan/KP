<?php

namespace KP\SOLID\Infra\App;

use KP\SOLID\Adapter\BaseAction;
use KP\SOLID\Adapter\Core\SignUpAction;

class HttpXmlApiRequestActionLoader extends BaseActionLoader{
    public function create() : BaseAction {
        
        $rootPath = substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], '/index.php'));
        $requestURI = substr($_SERVER["REQUEST_URI"], strlen($rootPath));

        if($_SERVER["REQUEST_METHOD"] === "POST" && $requestURI == "/sign-up"){
            $httpRequestBody = file_get_contents('php://input');
            $parsedXmlRequest = simplexml_load_string($httpRequestBody);

            if($parsedXmlRequest === false){
                throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], file_get_contents('php://input'), 'invalid XML request');
            }

            if(!isset($parsedXmlRequest->email)){
                throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], file_get_contents('php://input'), 'email parameter not defined');
            }

            if(!isset($parsedXmlRequest->password)){
                throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], file_get_contents('php://input'), 'password parameter not defined');
            }

            if(!isset($parsedXmlRequest->password_repeat)){
                throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], file_get_contents('php://input'), 'password_repeat parameter not defined');
            }

            return new SignUpAction($parsedXmlRequest->email, $parsedXmlRequest->password, $parsedXmlRequest->password_repeat);
        }

        throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], file_get_contents('php://input'), 'Unsupported action');
    }
}