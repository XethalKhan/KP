<?php

namespace KP\SOLID\Infra\View\Page;

use KP\SOLID\Infra\View\BaseView;
use KP\SOLID\Adapter\BaseViewModel;

abstract class BasePageView extends BaseView{

    protected $title;

    public function __construct(BaseViewModel $viewModel, string $title = 'KP SOLID DEMO'){
        parent::__construct($viewModel);
        $this->title = $title;
    }

    public function display() : void {
        header('Content-Type: text/html');

        echo "<html><head>";
        echo "<title>{$this->title}</title>";
        echo "<!-- Latest compiled and minified CSS -->";
        echo "<link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css\" rel=\"stylesheet\">";
        echo "<!-- Latest compiled JavaScript -->";
        echo "<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js\"></script>";
        echo "</head>";
        echo "<body>";
        echo "<div class=\"container\">";
        echo "<br/><br/><br/>";
        echo $this->renderBody();
        echo "</div>";
        echo "</body>";
    }

    public abstract function renderBody() : string;
}