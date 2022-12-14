<?php

namespace KP\SOLID\Infra\App;

use KP\SOLID\Adapter\BaseAction;
use KP\SOLID\Adapter\Core\SignUpAction;

class HttpJsonApiRequestActionLoader extends BaseActionLoader{
    public function create() : BaseAction {

        $rootPath = substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], '/index.php'));
        $requestURI = substr($_SERVER["REQUEST_URI"], strlen($rootPath));

        if($_SERVER["REQUEST_METHOD"] === "POST" && $requestURI == "/sign-up"){
            $httpRequestBody = file_get_contents('php://input');
            $parsedJsonRequest = json_decode($httpRequestBody);

            if($parsedJsonRequest === null){
                throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], file_get_contents('php://input'), 'invalid JSON request');
            }

            if(!isset($parsedJsonRequest->email)){
                throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], file_get_contents('php://input'), 'email parameter not defined');
            }

            if(!isset($parsedJsonRequest->password)){
                throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], file_get_contents('php://input'), 'password parameter not defined');
            }

            if(!isset($parsedJsonRequest->password_repeat)){
                throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], file_get_contents('php://input'), 'password_repeat parameter not defined');
            }

            return new SignUpAction($parsedJsonRequest->email, $parsedJsonRequest->password, $parsedJsonRequest->password_repeat);
        }

        throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], file_get_contents('php://input'), 'Unsupported action');
    }
}