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
        $menu = $this->showMenu();
        $forms[] = 'templates/postForm.php';
        $forms[] = 'templates/logoutForm.php';

        $data = '';
        foreach($this->model->getData() as $post => $value) {
            $data .= '<article>';
            $data .= '<h2>' . $value['post_title'] . '</h2>';
            $data .= '<p>' . $value['post_content'] . '</p>';
            $data .= '</article>';
        }
        
        require_once($this->model->getTemplate());
    }

    /**
     * Shows all posts from database
     *
     * @return void
     */
    public function showAllPosts()
    {
        $style = $this->style;
        $menu = $this->showMenu();
        $forms[] = 'templates/postForm.php';
        $forms[] = 'templates/logoutForm.php';

        $data = '';
        // var_dump($this->model->getData());
        foreach($this->model->getData() as $post => $value) {
            $data .= '<article>';
            $data .= '<h2>' . $value['title'] . '</h2>';
            $data .= '<p>' . $value['content'] . '</p>';
            $data .= '</article>';
        }
        
        require_once($this->model->getTemplate());
    }

    public function showAllCommunities()
    {
        $style = $this->model->getStylesheet();
        $menu = $this->showMenu();
        $forms[] = 'templates/logoutForm.php';

        $data = '<table>';
        $data .= '<tr><th>ID</th><th>Name</th><th>image url</th></tr>';
        // var_dump($this->model->getAllCommunities());
        foreach($this->model->getAllCommunities() as $community => $value) {
            $data .= '<tr>';
            $data .= '<td>' . $value['id'] . '</td>';
            $data .= '<td>' . $value['name'] . '</td>';
            $data .= '<td>' . $value['img_url'] . '</td>';
            $data .= '<td>' . $this->showButtons('join_community', 'id', $value['id'], 'Join') . '</td>';
            $data .= '</tr>';
        }
        $data .= '</table>';

        require_once($this->model->getTemplate());
    }
}