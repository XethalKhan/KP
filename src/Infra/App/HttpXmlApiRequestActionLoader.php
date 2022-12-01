<?php

namespace KP\SOLID\Infra\App;

use DOMDocument;
use KP\SOLID\Adapter\BaseAction;
use KP\SOLID\Adapter\Core\SignUpAction;

class HttpXmlApiRequestActionLoader extends BaseActionLoader{
    public function create() : BaseAction {
        
        $rootPath = substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], '/index.php'));
        $requestURI = substr($_SERVER["REQUEST_URI"], strlen($rootPath));

        if($_SERVER["REQUEST_METHOD"] === "POST" && $requestURI == "/sign-up"){
            libxml_use_internal_errors(true);
            $xmlRequest = new DOMDocument();
            $loadSuccess = $xmlRequest->loadXML(file_get_contents('php://input'));

            if($loadSuccess === false){
                throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], file_get_contents('php://input'), 'invalid XML request');
            }

            if(!$xmlRequest->schemaValidate("solid.xsd")){
                $errors = libxml_get_errors();
                $errorMessage = "";
                foreach($errors as $error){
                    $errorMessage .= $error->message;
                }
                throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], file_get_contents('php://input'), 'XML schema format not satisfied ' . $errorMessage);
            }

            $email = $xmlRequest->getElementsByTagName('email')->item(0)->nodeValue;
            if($email === null){
                throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], file_get_contents('php://input'), 'email parameter not defined');
            }

            $password = $xmlRequest->getElementsByTagName('password')->item(0)->nodeValue;
            if($password === null){
                throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], file_get_contents('php://input'), 'password parameter not defined');
            }

            $password_repeat = $xmlRequest->getElementsByTagName('password_repeat')->item(0)->nodeValue;
            if($password_repeat === null){
                throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], file_get_contents('php://input'), 'password_repeat parameter not defined');
            }

            return new SignUpAction($email, $password, $password_repeat);
        }

        throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], file_get_contents('php://input'), 'Unsupported action');
    }
}