<?php
namespace View;

class Posts extends AbstractView {

    /**
     * Show all post per community
     *
     * @return void
     */
    public function showCommunityPosts()
    {
        $style = $this->model->getStylesheet();
        $data = '';
        $data .= $this->model->getPostsByCommunity()[0];

        require_once($this->model->getTemplate());
    }

    /**
     * Shows all posts from database
     *
     * @return void
     */
    public function showAllPosts()
    {
        $style = $this->model->getStylesheet();
        $data = '';
        // var_dump($this->model->getData());
        foreach($this->model->getData() as $post => $value) {
            $data .= '<article>';
            $data .= '<h2>' . $value['post_title'] . '</h2>';
            $data .= '<p>' . $value['post_content'] . '</p>';
            $data .= '</article>';
        }

        $postForm = '
            <form id="post_form" action="" method="POST" enctype="multipart/form-data">
            <label for="post_title"></label><input type="text" name="post_title">
            <label for="post_content"></label><input type="text" name="post_content">
            </form>
        ';

        require_once($this->model->getTemplate());
    }

    public function showLoginForm()
    {
        $style = $this->model->getStylesheet();
        $loginForm = include 'templates/loginForm.php';

        $data = include 'templates/registerForm.php';

        require_once($this->model->getTemplate());
    }
}