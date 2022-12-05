<?php

namespace KP\SOLID\Infra\Mailer;

use KP\SOLID\UseCase\IMailer;
use KP\SOLID\UseCase\MailerException;

class SimpleMailer implements IMailer {

    public function __construct(){
    }

    public function send($from, $to, $subject, $message)
    {
        if(!mail($to, $subject, $message, ['From' => $from])){
            throw new MailerException($this, "Simple mailer failed");
        }
    }
}