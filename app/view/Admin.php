<?php
namespace View;

class Admin extends AbstractView {

    public function showUsers()
    {
        $style = $this->model->getStylesheet();
        $data = 'All users data';

        require_once($this->model->getTemplate());
    }
}