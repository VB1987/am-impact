<?php
namespace Controllers;

class Posts extends AbstractController {
    protected $loginStatus = false;

    public function allPosts()
    {
        $this->model->getAllPosts();
    }

    public function PostsByCommunity()
    {
        $this->model->getPostsByCommunity();
    }

    // public function login()
    // {
    //     if($_POST['username']) {
    //         $username = $_POST['username'];
    //     }
    //     if($_POST['password']) {
    //         $password = $_POST['password'];
    //     }
    // }

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

    // public function registerForm()
    // {
    //     $this->view->showForm('registerForm.php');
    // }

    // public function loginForm()
    // {
    //     $this->view->showForm('loginForm.php');
    // }

    public function logout()
    {
        $this->model->logout();
    }
}