<?php

namespace KP\SOLID\Infra\Mailer;

use Exception;
use KP\SOLID\UseCase\ILogger;
use KP\SOLID\UseCase\IMailer;
use KP\SOLID\UseCase\LoggerException;
use KP\SOLID\UseCase\MailerException;

class DummyMailer implements IMailer {

    private $logger;

    public function __construct(ILogger $logger){
        $this->logger = $logger;
    }

    public function send($from, $to, $subject, $message)
    {
        try {
            $this->logger->debug("DummyMailer->send() call. Example of 'mail' function call: mail('{$to}', '{$subject}', '{$message}', ['From' => '{$from}'])");
        } catch (LoggerException $e) {
            throw new MailerException($this, "Dummy mailer failed because of logger " . get_class($this->logger), 0, $e);
        } catch (Exception $e) {
            throw new MailerException($this, "Dummy mailer failed", 0, $e);
        }
    }
}