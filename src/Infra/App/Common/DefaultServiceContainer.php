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
use Throwable;

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

        throw new ServiceContainerException($this, "Unsupported parameter {$parameterType} in service container " . __CLASS__);
    }

    protected function createPresenter(string $context) : BasePresenter{
        if(!isset($this->executionContextMapping[$context]['PRESENTER'])){
            throw new ServiceContainerException($this, "Presenter not loaded for domain {$context}");
        }

        try{
            $reflectionClass = new ReflectionClass($this->executionContextMapping[$context]['PRESENTER']);
        } catch (Throwable $e){
            throw new ServiceContainerException($this, "Class " . $this->executionContextMapping[$context]['PRESENTER'] . " not defined", $e->getCode(), $e);
        }

        try{
            $presenter = $reflectionClass->newInstance();
        } catch (Throwable $e){
            throw new ServiceContainerException($this, "Class " . $this->executionContextMapping[$context]['PRESENTER'] . " not instantiated", $e->getCode(), $e);
        }

        return $presenter;
    }

    protected function createUseCaseInteractor(string $context, BasePresenter $presenter) : BaseUseCaseInteractor {
        if(!isset($this->executionContextMapping[$context]['USECASEINTERACTOR'])){
            throw new ServiceContainerException($this, "Use case interactor not loaded for domain {$context}");
        }

        try{
            $reflectionClass = new ReflectionClass($this->executionContextMapping[$context]['USECASEINTERACTOR']);
        } catch (Throwable $e){
            throw new ServiceContainerException($this, "Class " . $this->executionContextMapping[$context]['USECASEINTERACTOR'] . " not defined", $e->getCode(), $e);
        }

        $reflectionConstructor = $reflectionClass->getConstructor();

        if($reflectionConstructor === null){
            throw new ServiceContainerException($this, "Constructor is not defined on use case interactor " . $this->executionContextMapping[$context]['USECASEINTERACTOR']);
        }

        $constructorParametersDefinition = $reflectionConstructor->getParameters();
        $constructorParameters = array();

        foreach($constructorParametersDefinition as $parameterDefinition){
            $parameterType = $parameterDefinition->getType();
            if($parameterType === null){
                throw new ServiceContainerException($this, "Parameter type is not defined in use case interactor " . $this->executionContextMapping[$context]['USECASEINTERACTOR']);
            }
            if($parameterType->getName() == 'KP\SOLID\UseCase\IOutputGateway'){
                $constructorParameters[] = $presenter;
                continue;
            }

            $constructorParameters[] = $this->loadServiceFromConstructorParameter($parameterDefinition);
        }

        try{
            $useCaseInteractor = $reflectionClass->newInstanceArgs($constructorParameters);
        } catch (Throwable $e){
            throw new ServiceContainerException($this, "Class " . $this->executionContextMapping[$context]['USECASEINTERACTOR'] . " not instantiated", $e->getCode(), $e);
        }

        if($useCaseInteractor === null){
            throw new ServiceContainerException($this, "Reflection unable to instantiate class " . $this->executionContextMapping[$context]['USECASEINTERACTOR']);
        }

        return $useCaseInteractor;
    }

    protected function createController(string $context, BaseUseCaseInteractor $useCaseInteractor) : BaseController {
        if(!isset($this->executionContextMapping[$context]['CONTROLLER'])){
            throw new ServiceContainerException($this, "Controller not loaded for domain {$context}");
        }

        try{
            $reflectionClass = new ReflectionClass($this->executionContextMapping[$context]['CONTROLLER']);
        } catch (Throwable $e){
            throw new ServiceContainerException($this, "Class " . $this->executionContextMapping[$context]['CONTROLLER'] . " not defined", $e->getCode(), $e);
        }

        $reflectionConstructor = $reflectionClass->getConstructor();

        if($reflectionConstructor === null){
            throw new ServiceContainerException($this, "Constructor is not defined on controller " . $this->executionContextMapping[$context]['CONTROLLER']);
        }

        $constructorParametersDefinition = $reflectionClass->getConstructor()->getParameters();
        $constructorParameters = array();

        foreach($constructorParametersDefinition as $parameterDefinition){
            $parameterType = $parameterDefinition->getType();
            if($parameterType === null){
                throw new ServiceContainerException($this, "Parameter type is not defined in constructor " . $this->executionContextMapping[$context]['CONTROLLER']);
            }

            if($parameterType->getName() == 'KP\SOLID\UseCase\IInputGateway'){
                $constructorParameters[] = $useCaseInteractor;
                continue;
            }

            $constructorParameters[] = $this->loadServiceFromConstructorParameter($parameterDefinition);
        }

        try{
            $controller = $reflectionClass->newInstanceArgs($constructorParameters);
        } catch (Throwable $e){
            throw new ServiceContainerException($this, "Class " . $this->executionContextMapping[$context]['CONTROLLER'] . " not instantiated", $e->getCode(), $e);
        }

        if($controller === null){
            throw new ServiceContainerException($this, "Reflection unable to instantiate class " . $this->executionContextMapping[$context]['CONTROLLER']);
        }

        return $controller;
    }
}