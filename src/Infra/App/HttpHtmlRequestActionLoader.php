<?php

namespace KP\SOLID\Infra\App;

use KP\SOLID\Adapter\BaseAction;
use KP\SOLID\Adapter\Core\SignUpAction;
use KP\SOLID\Adapter\Page\SignUpPageAction;

class HttpHtmlRequestActionLoader extends BaseActionLoader{
    public function create() : BaseAction {

        $rootPath = substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], '/index.php'));
        $requestURI = substr($_SERVER["REQUEST_URI"], strlen($rootPath));

        if($_SERVER["REQUEST_METHOD"] === "GET" && ($requestURI == "/sign-up" || $requestURI == "/")){
            return new SignUpPageAction();
        }

        if($_SERVER["REQUEST_METHOD"] === "POST" && $requestURI == "/sign-up"){
            if(!isset($_POST['email'])){
                throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], file_get_contents('php://input'), 'email parameter not defined');
            }

            if(!isset($_POST['password'])){
                throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], file_get_contents('php://input'), 'password parameter not defined');
            }

            if(!isset($_POST['password_repeat'])){
                throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], file_get_contents('php://input'), 'password_repeat parameter not defined');
            }

            return new SignUpAction($_POST['email'], $_POST['password'], $_POST['password_repeat']);
        }

        var_dump("NEMA ODGOVARAJUCE AKCIJE");

        throw new HttpActionLoaderException($this, $_SERVER["REQUEST_METHOD"], $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], file_get_contents('php://input'), 'Unsupported action');
    }
}