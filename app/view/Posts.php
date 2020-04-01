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
        $style = $this->style;
        $data = '';
        foreach($this->model->getData() as $post => $value) {
            $data .= '<article>';
            $data .= '<h2>' . $value['post_title'] . '</h2>';
            $data .= '<p>' . $value['post_content'] . '</p>';
            $data .= '</article>';
        }
        
        require_once($this->model->getTemplate());

        // include_once 'templates/postForm.php';
    }

    /**
     * Shows all posts from database
     *
     * @return void
     */
    public function showAllPosts()
    {
        $style = $this->style;
        $data = '';
        // var_dump($this->model->getData());
        foreach($this->model->getData() as $post => $value) {
            $data .= '<article>';
            $data .= '<h2>' . $value['post_title'] . '</h2>';
            $data .= '<p>' . $value['post_content'] . '</p>';
            $data .= '</article>';
        }
        
        require_once($this->model->getTemplate());

        // include_once 'templates/postForm.php';
    }

    // public function showForm($template)
    // {
    //     $style = $this->style;
    //     $form = 'templates/' . $template;

    //     require_once($this->model->getTemplate());
    // }
}