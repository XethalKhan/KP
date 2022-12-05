<?php

namespace KP\SOLID\Infra\App;

class PageServiceContainerBuilder extends DefaultServiceContainerBuilder {

    protected function mapActionsToContext(){
        parent::mapActionsToContext();
        $contexts = scandir("src/Adapter/Page");

        foreach($contexts as $context){
            if($context === '.' || $context === '..'){
                continue;
            }

            $actions = glob("src/Adapter/Page/" . $context . "/*Action.php");

            foreach($actions as $action){
                $this->actionToContextMapping["KP\\SOLID\\Adapter\\Page\\" . basename($action, ".php")] = strtoupper($context);
            }

        }
    }

    protected function loadPresenters(){
        $contexts = scandir("src/Adapter/Page");

        foreach($contexts as $context){
            if($context === '.' || $context === '..'){
                continue;
            }

            if(file_exists("src/Adapter/Page/" . $context . "/" . $context . "PagePresenter.php")){
                $this->executionContextMapping[strtoupper($context)]['PRESENTER'] = "KP\\SOLID\\Adapter\\Page\\" . $context . "PagePresenter";
            }
        }
    }

    protected function loadUseCaseInteractors(){
        $domains = scandir("src/UseCase/Page");

        foreach($domains as $domain){
            if($domain === '.' || $domain === '..'){
                continue;
            }

            if(file_exists("src/UseCase/Page/" . $domain . "/" . $domain. "PageUseCaseInteractor.php")){
                $this->executionContextMapping[strtoupper($domain)]['USECASEINTERACTOR'] = "KP\\SOLID\\UseCase\\Page\\" . $domain . "PageUseCaseInteractor";
            }
        }
    }

    protected function loadControllers(){
        $domains = scandir("src/Adapter/Page");

        foreach($domains as $domain){
            if($domain === '.' || $domain === '..'){
                continue;
            }

            if(file_exists("src/Adapter/Page/" . $domain . "/" . $domain. "PageController.php")){
                $this->executionContextMapping[strtoupper($domain)]['CONTROLLER'] = "KP\\SOLID\\Adapter\\Page\\" . $domain . "PageController";
            }
        }
    }

}