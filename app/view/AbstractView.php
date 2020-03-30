<?php
namespace View;

abstract class AbstractView
{
    protected $model;
    protected $controller;
    
    final public function __construct($controller, $model) {
        $this->model = $model;
        $this->controller = $controller;
    }
}
