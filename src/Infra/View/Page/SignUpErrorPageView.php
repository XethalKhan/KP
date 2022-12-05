<?php

namespace KP\SOLID\Infra\View\Page;

use KP\SOLID\Adapter\BaseViewModel;
use KP\SOLID\Adapter\Core\SignUpErrorViewModel;

class SignUpErrorPageView extends BasePageView{

    public function __construct(BaseViewModel $viewModel, string $title = "KP SOLID DEMO | ERROR"){
        parent::__construct($viewModel, $title);
    }

    public function renderBody() : string{
        if(!($this->viewModel instanceof SignUpErrorViewModel)){
            echo 'Unsupported view model';
        }

        $body = "<p class=\"alert alert-danger\">" . $this->viewModel->getMessage() . "</p>";
        $body .= "<form action=\"sign-up\" method=\"POST\">";
        $body .= "<div class=\"mb-3 mt-3\">";
        $body .= "<label for=\"email\">Email:</label>";
        $body .= "<input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"Enter email\" name=\"email\" value=\"" . $this->viewModel->getEmail() . "\">";
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