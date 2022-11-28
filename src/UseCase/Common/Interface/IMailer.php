<?php

namespace KP\SOLID\UseCase;

interface IMailer {
    public function send($from, $to, $subject, $message);
}