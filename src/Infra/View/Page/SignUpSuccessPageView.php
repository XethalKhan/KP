<?php

namespace KP\SOLID\Infra\View\Page;

use KP\SOLID\Adapter\BaseViewModel;
use KP\SOLID\Adapter\Core\SignUpSuccessViewModel;

class SignUpSuccessPageView extends BasePageView{

    public function __construct(BaseViewModel $viewModel){
        parent::__construct($viewModel);
    }

    public function renderBody() : string {
        if(!($this->viewModel instanceof SignUpSuccessViewModel)){
            return 'Unsupported view model';
        }

        $body = "<p class=\"alert alert-info\">A mail has been sent to verify your account.</p>";

        return $body;
    }
}