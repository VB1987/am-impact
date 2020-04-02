<?php
namespace Controllers;

abstract class AbstractController {
    protected $model;
    protected $loginStatus = false;

    final public function __construct($model)
    {
        $this->model = $model;
    }

    public function invoke($args)
    {
        $action = $args['action'];
        if($action == 'login') {
            $login = $this->model->validateLogin($args);
            
            if($login) {
                $this->loginStatus = true;
            } else {
                $this->loginStatus = false;
            }
        } elseif($action == 'register user') {
            $this->model->registerUser($args);
        } elseif($action == 'create community') {
            $this->model->createCommunity($args);
        } elseif($action == 'submit post') {
            $this->model->submitPost($args);
        }
    }
    
    public function sessionDestroy()
    {
        $this->model->sessionDestroy();
    }

    public function menu($args)
    {
        $this->model->setMenu($args);
    }
}