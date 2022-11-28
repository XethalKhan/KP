<?php

namespace KP\SOLID\UseCase\Core;

use KP\SOLID\Domain\ValidateEmailFormatPredicate;
use KP\SOLID\Domain\ValidatePasswordFormatPredicate;
use KP\SOLID\UseCase\Core\CreateUserCommand;
use KP\SOLID\UseCase\Core\UserQuery;
use KP\SOLID\UseCase\BaseUseCase;
use KP\SOLID\UseCase\BaseUseCaseInput;
use KP\SOLID\UseCase\IConfiguration;
use KP\SOLID\UseCase\ILogger;
use KP\SOLID\UseCase\IMailer;
use KP\SOLID\UseCase\IMailValidator;
use KP\SOLID\UseCase\InvalidUseCaseInputException;
use KP\SOLID\UseCase\IRepository;
use KP\SOLID\UseCase\ISession;

class SignUpUseCase extends BaseUseCase {

    private $repository;
    private $mailer;
    private $configuration;
    private $logger;
    private $session;
    private $validatePasswordPredicate;
    private $validateEmailPredicate;

    public function __construct(
        IRepository $repository,
        IMailer $mailer,
        IConfiguration $configuration,
        ISession $session,
        IMailValidator $mailValidator,
        ILogger $logger
    ){
        $this->repository = $repository;
        $this->mailer = $mailer;
        $this->configuration = $configuration;
        $this->logger = $logger;
        $this->session = $session;
        $this->mailValidator = $mailValidator;
        $this->validatePasswordPredicate = new ValidatePasswordFormatPredicate();
        $this->validateEmailPredicate = new ValidateEmailFormatPredicate();
    }

    public function execute(BaseUseCaseInput $input) {
        if(!($input instanceof SignUpUseCaseInput)){
            throw new InvalidUseCaseInputException($this, $input);
        }

        if(empty($input->getEmail())){
            $this->logger->error("Sign up: email is empty");
            return new SignUpUseCaseOutput($input->getEmail(), true, false, false, false, false, false, false);
        }

        if(!$this->validateEmailPredicate->check($input->getEmail())){
            $this->logger->error("Sign up: email is not in valid format");
            return new SignUpUseCaseOutput($input->getEmail(), false, true, false, false, false, false, false);
        }

        if(!($this->mailValidator->validate($input->getEmail()))){
            $this->logger->error("Sign up: email is blacklisted");
            return new SignUpUseCaseOutput($input->getEmail(), false, false, true, false, false, false, false);
        }

        if($input->getPassword() !== $input->getPasswordRepeat()){
            $this->logger->error("Sign up: passwords do not match");
            return new SignUpUseCaseOutput($input->getEmail(), false, false, false, true, false, false, false);
        }

        if(!$this->validatePasswordPredicate->check($input->getPassword())){
            $this->logger->error("Sign up: password is not in valid format");
            return new SignUpUseCaseOutput($input->getEmail(), false, false, false, false, true, false, false);
        }

        if(!$this->validatePasswordPredicate->check($input->getPasswordRepeat())){
            $this->logger->error("Sign up: repeated password is not in valid format");
            return new SignUpUseCaseOutput($input->getEmail(), false, false, false, false, false, true, false);
        }

        $queryResult = $this->repository->query(new UserQuery($input->getEmail()));

        if($queryResult->getNumberOfRecords() > 0){
            $this->logger->error("Sign up: user with specified mail already exists");
            return new SignUpUseCaseOutput($input->getEmail(), false, false, false, false, false, false, true);
        }

        $this->repository->create(new CreateUserCommand($input->getEmail(), $input->getPassword(), 'now - 10 days'));

        $this->mailer->send($this->configuration->get("MAILER.SENDER"), $input->getEmail(), $this->configuration->get("MAILER.SIGNUP.SUBJECT"), $this->configuration->get("MAILER.SIGNUP.MESSAGE"));

        $createdUserQueryResult = $this->repository->query(new UserQuery($input->getEmail()));

        $entity = $createdUserQueryResult->getRecords()[0];

        $this->session->set("userId", $entity->getID());

        return new SignUpUseCaseOutput($input->getEmail(), false, false, false, false, false, false, false);
    }

}