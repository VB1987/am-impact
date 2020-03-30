<?php
namespace View;

abstract class AbstractView
{
    protected $model;
    protected $controller;
    protected $style;
    
    final public function __construct($controller, $model) {
        $this->model = $model;
        $this->controller = $controller;

        $this->style = $this->model->getStylesheet();
    }
}
