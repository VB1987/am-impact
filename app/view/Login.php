<?php
namespace view;

class Login extends AbstractView {

    public function showLogin()
    {
        include 'templates/loginForm.php';
        include 'templates/registerForm.php';
    }
}