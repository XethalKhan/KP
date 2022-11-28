<?php

namespace KP\SOLID\UseCase\Page;

use KP\SOLID\UseCase\BaseUseCase;
use KP\SOLID\UseCase\BaseUseCaseInput;
use KP\SOLID\UseCase\Core\UserUseCaseInteractor;
use KP\SOLID\UseCase\IConfiguration;
use KP\SOLID\UseCase\ILogger;
use KP\SOLID\UseCase\IMailer;
use KP\SOLID\UseCase\IMailValidator;
use KP\SOLID\UseCase\IOutputGateway;
use KP\SOLID\UseCase\IRepositoryFactory;
use KP\SOLID\UseCase\ISession;

class UserPageUseCaseInteractor extends UserUseCaseInteractor {

    public function __construct(
        IOutputGateway $outputGateway,
        IRepositoryFactory $repositoryFactory,
        IMailer $mailer,
        IConfiguration $configuration,
        ILogger $logger,
        ISession $session,
        IMailValidator $mailValidator
    ){
        parent::__construct($outputGateway, $repositoryFactory, $mailer, $configuration, $logger, $session, $mailValidator);
    }

    protected function useCaseFactoryMethod(BaseUseCaseInput $input) : BaseUseCase {
        if($input instanceof SignUpPageUseCaseInput){
            return new SignUpPageUseCase();
        }

        return parent::useCaseFactoryMethod($input);
    }

}