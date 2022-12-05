<?php

namespace KP\SOLID\Infra\View\Page;

use KP\SOLID\Adapter\BaseViewModel;
use KP\SOLID\Adapter\Page\SignUpPageViewModel;
use KP\SOLID\Adapter\Core\SignUpErrorViewModel;
use KP\SOLID\Adapter\Core\SignUpSuccessViewModel;
use KP\SOLID\Adapter\ExceptionViewModel;
use KP\SOLID\Infra\View\BaseView;
use KP\SOLID\Infra\View\IViewFactory;
use KP\SOLID\Infra\View\Page\SignUpErrorPageView;
use KP\SOLID\Infra\View\Page\SignUpPageView;
use KP\SOLID\Infra\View\Page\SignUpSuccessPageView;

class PageViewFactory implements IViewFactory {

    public function __construct(){
    }

    public function create(BaseViewModel $viewModel) : BaseView {
        if ($viewModel instanceof ExceptionViewModel) {
            return new ExceptionPageView($viewModel);
        }

        if ($viewModel instanceof SignUpPageViewModel) {
            return new SignUpPageView($viewModel);
        }

        if ($viewModel instanceof SignUpErrorViewModel) {
            return new SignUpErrorPageView($viewModel);
        }

        if ($viewModel instanceof SignUpSuccessViewModel) {
            return new SignUpSuccessPageView($viewModel);
        }
    }

}