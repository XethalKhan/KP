<?php

namespace KP\SOLID\Infra\MailValidator;

use KP\SOLID\UseCase\IConfiguration;
use KP\SOLID\UseCase\ILogger;
use KP\SOLID\UseCase\IMailValidator;

class DummyMailValidator implements IMailValidator{

    protected $logger;
    protected $configuration;

    public function __construct(ILogger $logger, IConfiguration $configuration){
        $this->logger = $logger;
        $this->configuration = $configuration;
    }
    public function validate(string $email): bool
    {
        $emailSplitAtMonkeyCharacter = explode("@", $email);
        $authentication = base64_encode($this->configuration->get("MAXMIND.USER") . ":" . $this->configuration->get("MAXMIND.PASSWORD"));
        $this->logger->debug("DummyMailValidator->validate() call. Performs validation for email {$email}. Endpoint = https://minfraud.maxmind.com/minfraud/v2.0/score/email/address, method = POST, header Content-Type = application/json, header Authentication: Basic {$authentication}, body = {\"address\": \"{$email}\", \"domain\": \"{$emailSplitAtMonkeyCharacter[1]}\"}");
        return true;
    }
}