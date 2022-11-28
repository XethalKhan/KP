<?php

namespace KP\SOLID\UseCase;

use \Exception;
use \Throwable;

class MailerException extends Exception {

    protected $mailer;

    public function __construct(IMailer $mailer, $message = '', $code = 0, Throwable $previous = null){
        parent::__construct($message, $code, $previous);
        $this->$mailer = $mailer;
    }

    public function getMailer() : IMailer {
        return $this->mailer;
    }

}

