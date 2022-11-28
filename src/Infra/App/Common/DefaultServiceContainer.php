<?php

namespace KP\SOLID\Infra\App;

use KP\SOLID\Adapter\BaseController;
use KP\SOLID\Adapter\BasePresenter;
use KP\SOLID\UseCase\BaseUseCaseInteractor;
use KP\SOLID\UseCase\IConfiguration;
use KP\SOLID\UseCase\ILogger;
use KP\SOLID\UseCase\IMailer;
use KP\SOLID\UseCase\IMailValidator;
use KP\SOLID\UseCase\IRepositoryFactory;
use KP\SOLID\UseCase\ISession;
use ReflectionClass;
use RuntimeException;

class DefaultServiceContainer extends BaseServiceContainer {

    protected $executionContextMapping;

    public function __construct(
        IConfiguration $configuration,
        ILogger $logger,
        IRepositoryFactory $repositoryFactory,
        IMailer $mailer,
        ISession $session,
        IMailValidator $mailValidator,
        array $actionToContextMapping,
        array $executionContextMapping){

        parent::__construct($configuration, $logger, $repositoryFactory, $mailer, $session, $mailValidator, $actionToContextMapping);
        $this->executionContextMapping = $executionContextMapping;
        
    }

    private function loadServiceFromConstructorParameter($parameter){
        $parameterType = $parameter->getType()->getName();
        if($parameterType == 'KP\SOLID\UseCase\IConfiguration'){
            return $this->getConfiguration();
        }

        if($parameterType == 'KP\SOLID\UseCase\ILogger'){
            return $this->getLogger();
        }

        if($parameterType == 'KP\SOLID\UseCase\IRepositoryFactory'){
            return $this->getRepositoryFactory();
        }

        if($parameterType == 'KP\SOLID\UseCase\IMailer'){
            return $this->getMailer();
        }

        if($parameterType == 'KP\SOLID\UseCase\ISession'){
            return $this->getSession();
        }

        if($parameterType == 'KP\SOLID\UseCase\IMailValidator'){
            return $this->getMailValidator();
        }
    }

    protected function createPresenter(string $context) : BasePresenter{
        if(!isset($this->executionContextMapping[$context]['PRESENTER'])){
            throw new RuntimeException("Presenter not loaded for domain {$context}");
        }

        $reflectionClass = new ReflectionClass($this->executionContextMapping[$context]['PRESENTER']);
        return $reflectionClass->newInstance();
    }

    protected function createUseCaseInteractor(string $context, BasePresenter $presenter) : BaseUseCaseInteractor {
        if(!isset($this->executionContextMapping[$context]['USECASEINTERACTOR'])){
            throw new RuntimeException("Use case interactor not loaded for domain {$context}");
        }

        $reflectionClass = new ReflectionClass($this->executionContextMapping[$context]['USECASEINTERACTOR']);
        $constructorParametersDefinition = $reflectionClass->getConstructor()->getParameters();
        $constructorParameters = array();

        foreach($constructorParametersDefinition as $parameterDefinition){
            if($parameterDefinition->getType()->getName() == 'KP\SOLID\UseCase\IOutputGateway'){
                $constructorParameters[] = $presenter;
                continue;
            }

            $constructorParameters[] = $this->loadServiceFromConstructorParameter($parameterDefinition);
        }

        return $reflectionClass->newInstanceArgs($constructorParameters);
    }

    protected function createController(string $context, BaseUseCaseInteractor $useCaseInteractor) : BaseController {
        if(!isset($this->executionContextMapping[$context]['CONTROLLER'])){
            throw new RuntimeException("Controller not loaded for domain {$context}");
        }

        $reflectionClass = new ReflectionClass($this->executionContextMapping[$context]['CONTROLLER']);
        $constructorParametersDefinition = $reflectionClass->getConstructor()->getParameters();
        $constructorParameters = array();

        foreach($constructorParametersDefinition as $parameterDefinition){
            if($parameterDefinition->getType()->getName() == 'KP\SOLID\UseCase\IInputGateway'){
                $constructorParameters[] = $useCaseInteractor;
                continue;
            }

            $constructorParameters[] = $this->loadServiceFromConstructorParameter($parameterDefinition);
        }

        return $reflectionClass->newInstanceArgs($constructorParameters);
    }
}