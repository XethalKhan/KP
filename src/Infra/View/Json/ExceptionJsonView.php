<?php

namespace KP\SOLID\Infra\View\Json;

use KP\SOLID\Adapter\BaseViewModel;
use KP\SOLID\Adapter\ExceptionViewModel;
use KP\SOLID\Infra\App\ActionLoaderException;
use KP\SOLID\UseCase\InvalidUseCaseInputArgumentException;

class ExceptionJsonView extends BaseJsonView{

    public function __construct(BaseViewModel $viewModel){
        parent::__construct($viewModel);
    }

    public function display() : void {
        if(!($this->viewModel instanceof ExceptionViewModel)){
            echo 'Unsupported view model';
        }

        $exception = $this->viewModel->getException();

        http_response_code(500);
        
        if($exception instanceof ActionLoaderException || $exception instanceof InvalidUseCaseInputArgumentException){
            http_response_code(400);
        }

        parent::display();

        echo "{\"success\": false, \"error\": \"" . $exception->getMessage() . "\"}";
    }
}