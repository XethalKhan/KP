<?php

namespace KP\SOLID\UseCase\Core;

use KP\SOLID\UseCase\BaseUseCase;
use KP\SOLID\UseCase\BaseUseCaseInput;
use KP\SOLID\UseCase\BaseUseCaseInteractor;
use KP\SOLID\UseCase\IConfiguration;
use KP\SOLID\UseCase\ILogger;
use KP\SOLID\UseCase\IMailer;
use KP\SOLID\UseCase\IMailValidator;
use KP\SOLID\UseCase\IOutputGateway;
use KP\SOLID\UseCase\IRepositoryFactory;
use KP\SOLID\UseCase\ISession;

class UserUseCaseInteractor extends BaseUseCaseInteractor {

    protected $repositoryFactory;
    protected $mailer;
    protected $configuration;
    protected $logger;
    protected $session;
    protected $mailValidator;

    public function __construct(
        IOutputGateway $outputGateway,
        IRepositoryFactory $repositoryFactory,
        IMailer $mailer,
        IConfiguration $configuration,
        ILogger $logger,
        ISession $session,
        IMailValidator $mailValidator
    ){
        parent::__construct($outputGateway);
        $this->repositoryFactory = $repositoryFactory;
        $this->mailer = $mailer;
        $this->configuration = $configuration;
        $this->logger = $logger;
        $this->session = $session;
        $this->mailValidator = $mailValidator;
    }

    protected function useCaseFactoryMethod(BaseUseCaseInput $input) : BaseUseCase {
        if($input instanceof SignUpUseCaseInput){
            return new SignUpUseCase($this->repositoryFactory->create("USER"), $this->mailer, $this->configuration, $this->session, $this->mailValidator, $this->logger);
        }

        return parent::useCaseFactoryMethod($input);
    }

}