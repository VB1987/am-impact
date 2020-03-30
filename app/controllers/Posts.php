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

    public function login()
    {
        if($_POST['username']) {
            $username = $_POST['username'];
        }
        if($_POST['password']) {
            $username = $_POST['password'];
        }
    }

    public function invoke()
    {
        $login = $this->model->validateLogin();
        
        if($login) {
            $this->loginStatus = true;
        } else {
            $this->loginStatus = false;
        }
    }

    public function getLoginStatus()
    {
        return $this->loginStatus;
    }
}