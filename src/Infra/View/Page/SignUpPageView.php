<?php

namespace KP\SOLID\Infra\View\Page;

use InvalidArgumentException;
use KP\SOLID\Adapter\BaseViewModel;
use KP\SOLID\Adapter\Page\SignUpPageViewModel;

class SignUpPageView extends BasePageView {

    public function __construct(BaseViewModel $viewModel, string $title = 'KP SOLID DEMO | SIGN UP'){
        parent::__construct($viewModel, $title);
    }

    public function renderBody() : string{
        if(!($this->viewModel instanceof SignUpPageViewModel)){
            echo 'Unsupported view model';
        }

        $body = "<p class=\"alert alert-info\">" . $this->viewModel->getPasswordRequirementsMessage() . "</p>";
        $body .= "<form action=\"sign-up\" method=\"POST\">";
        $body .= "<div class=\"mb-3 mt-3\">";
        $body .= "<label for=\"email\">Email:</label>";
        $body .= "<input type=\"text\" class=\"form-control\" id=\"email\" placeholder=\"Enter email\" name=\"email\">";
        $body .= "</div>";
        $body .= "<div class=\"mb-3\">";
        $body .= "<label for=\"password\">Password:</label>";
        $body .= "<input type=\"password\" class=\"form-control\" id=\"pwd\" placeholder=\"Enter password\" name=\"password\">";
        $body .= "</div>";
        $body .= "<div class=\"mb-3\">";
        $body .= "<label for=\"password_repeat\">Repeat password:</label>";
        $body .= "<input type=\"password\" class=\"form-control\" id=\"password_repeat\" placeholder=\"Enter password\" name=\"password_repeat\">";
        $body .= "</div>";
        $body .= "<div class=\"text-center\">";
        $body .= "<button type=\"submit\" class=\"btn btn-primary center text\">Submit</button>";
        $body .= "</div>";
        $body .= "</form>";

        return $body;
    }
}