<?php
namespace View;

class Posts extends AbstractView {

    /**
     * Show all post per community
     */
    public function showCommunityPosts()
    {
        $style = $this->style;
        $menu = $this->showMenu();
        $communities = $this->model->getJoinedCommunitiesByUser();
        $forms[] = 'templates/postForm.php';
        $forms[] = 'templates/logoutForm.php';

        $data = '';
        if($this->model->getData()) {
            foreach($this->model->getData() as $post => $value) {
                if($this->model->getLikes($value['id'])) {
                    $buttonText = $this->model->getLikes($value['id']) . ' likes';
                } else {
                    $buttonText = 'Like';
                }
                
                $data .= '<article>';
                $data .= '<h2>' . $value['post_title'] . '</h2>';
                $data .= '<p>' . $value['post_content'] . '</p>';
                $data .= '<p>' . $value['post_date'] . '</p>';
                $data .= '<td>' . $this->showButton('like_post', 'id', $value['id'], $buttonText) . '</td>';
                $data .= '</article>';
            }
        }
        
        require_once($this->model->getTemplate());
    }

    /**
     * Show all communities
     */
    public function showAllCommunities()
    {
        $style = $this->model->getStylesheet();
        $menu = $this->showMenu();
        $forms[] = 'templates/communityForm.php';
        $forms[] = 'templates/logoutForm.php';

        $data = '<table>';
        $data .= '<tr><th>ID</th><th>Name</th><th>image</th></tr>';
        
        foreach($this->model->getAllCommunities() as $community => $value) {
            $image = json_decode($value['image']) ?? false;
            
            $data .= '<tr>';
            $data .= '<td>' . $value['id'] . '</td>';
            $data .= '<td>' . $value['name'] . '</td>';
            if($image) {
                $data .= '<td><img src="resources/images/' . $image->name . '"></td>';
            } else {
                $data .= '<td></td>';
            }
            $data .= '<td>' . $this->showButton('join_community', 'id', $value['id'], 'Join') . $this->showButton('leave_community', 'id', $value['id'], 'Leave') . '</td>';
            $data .= '</tr>';
        }
        $data .= '</table>';

        require_once($this->model->getTemplate());
    }
}