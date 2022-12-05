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
use KP\SOLID\UseCase\StorageException;

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
        $this->validatePasswordPredicate = new ValidatePasswordFormatPredicate(intval($this->configuration->get("PASSWORD.MIN_LENGTH")));
        $this->validateEmailPredicate = new ValidateEmailFormatPredicate();
    }

    public function execute(BaseUseCaseInput $input) {
        try{

            if(!($input instanceof SignUpUseCaseInput)){
                throw new InvalidUseCaseInputException($this, $input);
            }

            $success = 0;

            if(empty($input->getEmail())){
                $this->logger->error("Sign up: email is empty");
                $success = $success | SIGN_UP_USE_CASE_ERROR_EMPTY_EMAIL;
            }

            if(!$this->validateEmailPredicate->check($input->getEmail())){
                $this->logger->error("Sign up: email {$input->getEmail()} is not in valid format");
                $success = $success | SIGN_UP_USE_CASE_ERROR_INVALID_EMAIL_FORMAT;
            }

            if(!($this->mailValidator->validate($input->getEmail()))){
                $this->logger->error("Sign up: email {$input->getEmail()} is blacklisted");
                $success = $success | SIGN_UP_USE_CASE_ERROR_BLACKLISTED_EMAIL;
            }

            if($input->getPassword() !== $input->getPasswordRepeat()){
                $this->logger->error("Sign up: passwords do not match");
                $success = $success | SIGN_UP_USE_CASE_ERROR_PASSWORD_MISMATCH;
            }

            if(!$this->validatePasswordPredicate->check($input->getPassword())){
                $this->logger->error("Sign up: password is not in valid format");
                $success = $success | SIGN_UP_USE_CASE_ERROR_INVALID_PASSWORD;
            }

            if(!$this->validatePasswordPredicate->check($input->getPasswordRepeat())){
                $this->logger->error("Sign up: repeated password is not in valid format");
                $success = $success | SIGN_UP_USE_CASE_ERROR_INVALID_PASSWORD_REPEAT;
            }

            if($success != SIGN_UP_USE_CASE_NO_ERRORS){
                return new SignUpUseCaseOutput($input->getEmail(), 0, $success);
            }

            $queryResult = $this->repository->query(new UserQuery($input->getEmail()));

            if($queryResult->getNumberOfRecords() > 0){
                $this->logger->error("Sign up: user with specified mail already exists");
                return new SignUpUseCaseOutput($input->getEmail(), 0, SIGN_UP_USE_CASE_ERROR_USER_EXISTS);
            }

            $this->repository->create(new CreateUserCommand($input->getEmail(), $input->getPassword()));

            $this->mailer->send($this->configuration->get("MAILER.SENDER"), $input->getEmail(), $this->configuration->get("MAILER.SIGNUP.SUBJECT"), $this->configuration->get("MAILER.SIGNUP.MESSAGE"));

            $createdUserQueryResult = $this->repository->query(new UserQuery($input->getEmail()));

            $entity = $createdUserQueryResult->getRecords()[0];

            $this->session->set("userId", $entity->getID());

            return new SignUpUseCaseOutput($input->getEmail(), $entity->getID(), SIGN_UP_USE_CASE_NO_ERRORS);
        } catch (StorageException $e){
            $this->logger->error($e->getMessage());
            $this->logger->error("Stack trace:\n" . $e->getTraceAsString());
            $success = $success | SIGN_UP_USE_CASE_STORAGE_ERROR;
            return new SignUpUseCaseOutput($input->getEmail(), 0, $success);
        }
    }

}