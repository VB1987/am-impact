<?php
namespace View;

class Users extends AbstractView {

    public function showUsers()
    {
        $style = $this->model->getStylesheet();
        $forms[] = 'templates/logout.php';
        $data = 'All users data';

        require_once($this->model->getTemplate());
    }

    public function showLoginForm()
    {
        $style = $this->model->getStylesheet();
        $forms[] = 'templates/loginForm.php';
        $forms[] = 'templates/registerForm.php';

        require_once($this->model->getTemplate());
    }
}