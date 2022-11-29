<?php

namespace KP\SOLID\Infra\App;

use KP\SOLID\Infra\Configuration\EnvFileConfiguration;
use KP\SOLID\Infra\Logger\FileLogger;
use KP\SOLID\Infra\Mailer\DummyMailer;
use KP\SOLID\Infra\MailValidator\DummyMailValidator;
use KP\SOLID\Infra\Session\DefaultSession;
use KP\SOLID\Infra\Storage\Mysqli\MysqliRepositoryFactory;
use KP\SOLID\UseCase\IConfiguration;
use KP\SOLID\UseCase\ILogger;

class DefaultServiceContainerBuilder extends BaseServiceContainerBuilder {
    protected $actionToContextMapping;
    protected $executionContextMapping;

    protected function buildConfiguration(){
        return new EnvFileConfiguration();
    }

    protected function buildLogger(IConfiguration $configuration){
        if($configuration->has("LOGGER.FILE.DESTINATION")){
            return new FileLogger($configuration->get("LOGGER.FILE.DESTINATION"));
        }

        return new FileLogger();
    }

    protected function buildRepositoryFactory(IConfiguration $configuration, ILogger $logger){
        $host = "localhost";
        $user = "root";
        $password = "";
        $database = "kp";
        $port = 3306;


        if($configuration->has("STORAGE.MYSQLI.HOST")){
            $host = $configuration->get("STORAGE.MYSQLI.HOST");
        }

        if($configuration->has("STORAGE.MYSQLI.USER")){
            $user = $configuration->get("STORAGE.MYSQLI.USER");
        }

        if($configuration->has("STORAGE.MYSQLI.PASSWORD")){
            $password = $configuration->get("STORAGE.MYSQLI.PASSWORD");
        }

        if($configuration->has("STORAGE.MYSQLI.DATABASE")){
            $database = $configuration->get("STORAGE.MYSQLI.DATABASE");
        }

        if($configuration->has("STORAGE.MYSQLI.PORT")){
            $port = $configuration->get("STORAGE.MYSQLI.PORT");
        }

        return new MysqliRepositoryFactory($host, $user, $password, $database, $port);
    }

    protected function buildMailer(IConfiguration $configuration, ILogger $logger){
        return new DummyMailer($logger);
    }

    protected function buildSession(IConfiguration $configuration, ILogger $logger){
        return new DefaultSession();
    }

    protected function buildMailValidator(IConfiguration $configuration, ILogger $logger){
        return new DummyMailValidator($logger, $configuration);
    }

    protected function mapActionsToContext(){
        $contexts = scandir("src/Adapter/Core");

        foreach($contexts as $context){
            if($context === '.' || $context === '..'){
                continue;
            }

            $actions = glob("src/Adapter/Core/" . $context . "/*Action.php");

            foreach($actions as $action){
                $this->actionToContextMapping["KP\\SOLID\\Adapter\\Core\\" . basename($action, ".php")] = strtoupper($context);
            }

        }
    }

    protected function loadPresenters(){
        $contexts = scandir("src/Adapter/Core");

        foreach($contexts as $context){
            if($context === '.' || $context === '..'){
                continue;
            }

            if(file_exists("src/Adapter/Core/" . $context . "/" . $context . "Presenter.php")){
                $this->executionContextMapping[strtoupper($context)]['PRESENTER'] = "KP\\SOLID\\Adapter\\Core\\" . $context . "Presenter";
            }
        }
    }

    protected function loadUseCaseInteractors(){
        $domains = scandir("src/UseCase/Core");

        foreach($domains as $domain){
            if($domain === '.' || $domain === '..'){
                continue;
            }

            if(file_exists("src/UseCase/Core/" . $domain . "/" . $domain. "UseCaseInteractor.php")){
                $this->executionContextMapping[strtoupper($domain)]['USECASEINTERACTOR'] = "KP\\SOLID\\UseCase\\Core\\" . $domain . "UseCaseInteractor";
            }
        }
    }

    protected function loadControllers(){
        $domains = scandir("src/Adapter/Core");

        foreach($domains as $domain){
            if($domain === '.' || $domain === '..'){
                continue;
            }

            if(file_exists("src/Adapter/Core/" . $domain . "/" . $domain. "Controller.php")){
                $this->executionContextMapping[strtoupper($domain)]['CONTROLLER'] = "KP\\SOLID\\Adapter\\Core\\" . $domain . "Controller";
            }
        }
    }

    public function build() : BaseServiceContainer{
        $configuration = $this->buildConfiguration();
        $logger = $this->buildLogger($configuration);
        $repositoryFactory = $this->buildRepositoryFactory($configuration, $logger);
        $mailer = $this->buildMailer($configuration, $logger);
        $session = $this->buildSession($configuration, $logger);
        $mailValidator = $this->buildMailValidator($configuration, $logger);

        $this->mapActionsToContext();
        $this->loadPresenters();
        $this->loadUseCaseInteractors();
        $this->loadControllers();

        return new DefaultServiceContainer(
            $configuration,
            $logger,
            $repositoryFactory,
            $mailer,
            $session,
            $mailValidator,
            $this->actionToContextMapping,
            $this->executionContextMapping
        );
    }

}