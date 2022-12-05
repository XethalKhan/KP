<?php

namespace KP\SOLID\Infra\View\Page;

use KP\SOLID\Adapter\BaseViewModel;
use KP\SOLID\Adapter\ExceptionViewModel;
use KP\SOLID\Infra\App\ActionLoaderException;
use KP\SOLID\UseCase\InvalidUseCaseInputArgumentException;

class ExceptionPageView extends BasePageView{

    public function __construct(BaseViewModel $viewModel){
        parent::__construct($viewModel);
    }

    public function renderBody() : string {
        if(!($this->viewModel instanceof ExceptionViewModel)){
            echo 'Unsupported view model';
        }

        $exception = $this->viewModel->getException();

        http_response_code(500);
        
        if($exception instanceof ActionLoaderException || $exception instanceof InvalidUseCaseInputArgumentException){
            http_response_code(400);
        }

        $body = "<p class=\"alert alert-danger\">" . $exception->getMessage() . "</p>";

        return $body;
    }
}