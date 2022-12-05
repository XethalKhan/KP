<?php

namespace KP\SOLID\Infra\App;

use KP\SOLID\Adapter\BaseAction;
use KP\SOLID\Adapter\BaseController;
use KP\SOLID\Adapter\BasePresenter;
use KP\SOLID\UseCase\BaseUseCaseInteractor;
use KP\SOLID\UseCase\IConfiguration;
use KP\SOLID\UseCase\ILogger;
use KP\SOLID\UseCase\IMailer;
use KP\SOLID\UseCase\IMailValidator;
use KP\SOLID\UseCase\IRepositoryFactory;
use KP\SOLID\UseCase\ISession;

abstract class BaseServiceContainer {

    protected $configuration;
    protected $logger;
    protected $repositoryFactory;
    protected $mailer;
    protected $session;
    protected $mailValidator;
    protected $actionToContextMapping;

    public function __construct(
        IConfiguration $configuration,
        ILogger $logger,
        IRepositoryFactory $repositoryFactory,
        IMailer $mailer,
        ISession $session,
        IMailValidator $mailValidator,
        array $actionToContextMapping){

        $this->configuration = $configuration;
        $this->logger = $logger;
        $this->repositoryFactory = $repositoryFactory;
        $this->mailer = $mailer;
        $this->session = $session;
        $this->mailValidator = $mailValidator;
        $this->actionToContextMapping = $actionToContextMapping;

    }

    public function getConfiguration() : IConfiguration {
        return $this->configuration;
    }

    public function getLogger() : ILogger {
        return $this->logger;
    }

    public function getRepositoryFactory() {
        return $this->repositoryFactory;
    }

    public function getMailer() {
        return $this->mailer;
    }

    public function getSession() {
        return $this->session;
    }

    public function getMailValidator() {
        return $this->mailValidator;
    }

    public function getExecutionContext(BaseAction $action){
        $context = $this->actionToContextMapping[get_class($action)];
        
        $presenter = $this->createPresenter($context);

        $useCaseInteractor = $this->createUseCaseInteractor($context, $presenter);

        $controller = $this->createController($context, $useCaseInteractor);

        return new ExecutionContext($controller, $presenter);
    }

    protected abstract function createPresenter(string $context) : BasePresenter;

    protected abstract function createUseCaseInteractor(string $context, BasePresenter $presenter) : BaseUseCaseInteractor;

    protected abstract function createController(string $context, BaseUseCaseInteractor $useCaseInteractor) : BaseController;


}