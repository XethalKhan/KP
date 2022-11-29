<?php

namespace KP\SOLID\Infra\MailValidator;

use KP\SOLID\UseCase\IConfiguration;
use KP\SOLID\UseCase\IMailValidator;
use RuntimeException;

class MaxMindMailValidator implements IMailValidator{

    protected $user;
    protected $password;

    public function __construct(IConfiguration $configuration){
        $this->user = $configuration->get("MAXMIND.USER");
        $this->password = $configuration->get("MAXMIND.PASSWORD");
    }
    public function validate(string $email): bool
    {
        if(strlen($email) > 255){
            return false;
        }

        $emailSplitAtMonkeyCharacter = explode("@", $email);

        $curlHandle = curl_init();

        curl_setopt($curlHandle, CURLOPT_URL, "https://minfraud.maxmind.com/minfraud/v2.0/score/email/address");
        curl_setopt($curlHandle, CURLOPT_HEADER, false);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, [
            'Content-Type' => 'application/json',
            'Authorization: Basic '. base64_encode($this->username . ':' . $this->password)
        ]);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_POST, true);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode(["address" => $email, "domain" => $emailSplitAtMonkeyCharacter[1]]));

        $response = curl_exec($curlHandle);

        if($response === false){
            throw new RuntimeException("Error with MaxMind API, unable to connect.");
        }

        $responseObject = json_decode($response);

        if($responseObject === null){
            throw new RuntimeException("Error with MaxMind API, unable to parse response body.");
        }

        return !$responseObject->is_high_risk && !$responseObject->is_disposable;
    }
}