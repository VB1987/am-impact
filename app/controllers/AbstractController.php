<?php
namespace Controllers;

abstract class AbstractController {
    protected $model;

    final public function __construct($model)
    {
        $this->model = $model;
    }
}