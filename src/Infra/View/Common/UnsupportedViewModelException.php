<?php

namespace KP\SOLID\Infra\View;

use \Exception;
use KP\SOLID\Adapter\BaseViewModel;
use \Throwable;

class UnsupportedViewModelException extends Exception {

    protected $viewFactory;
    protected $viewModel;

    public function __construct(IViewFactory $viewFactory, BaseViewModel $viewModel, $message = '', $code = 0, Throwable $previous = null){
        parent::__construct($message, $code, $previous);
        $this->$viewFactory = $viewFactory;
        $this->$viewModel = $viewModel;
        if($message === ''){
            $this->message = "View factory " . get_class($this->viewFactory) . " does not support view model " . get_class($this->viewModel);
        }
    }

    public function getViewFactory() : IViewFactory {
        return $this->viewFactory;
    }

    public function getViewModel() : BaseViewModel {
        return $this->viewModel;
    }

}

