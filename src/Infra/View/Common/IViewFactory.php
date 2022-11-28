<?php

namespace KP\SOLID\Infra\View;

use KP\SOLID\Adapter\BaseViewModel;

interface IViewFactory {
    public function create(BaseViewModel $viewModel);
}