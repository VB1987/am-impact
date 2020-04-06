<?php
namespace View;

class Admin extends AbstractView {

    public function showAllUsers()
    {
        $style = $this->model->getStylesheet();
        $menu = $this->showMenu();
        $forms[] = 'templates/logoutForm.php';

        $data = '<table>';
        $data .= '<tr><th>ID</th><th>Firstname</th><th>Lastname</th><th>Email</th><th>Is admin</th><th>Blocked</th><th>Member of communities</th><th>Liked posts</th></tr>';
        
        foreach($this->model->getAllUsers() as $user => $value) {
            $data .= '<tr>';
            $data .= '<td>' . $value['id'] . '</td>';
            $data .= '<td>' . $value['firstname'] . '</td>';
            $data .= '<td>' . $value['lastname'] . '</td>';
            $data .= '<td>' . $value['email'] . '</td>';
            $data .= '<td>' . $value['admin'] . '</td>';
            $data .= '<td>' . $value['blocked'] . '</td>';
            $data .= '<td>' . $value['community_id'] . '</td>';
            $data .= '<td>' . $value['liked_post_ids'] . '</td>';
            $data .= '<td>' . $this->showButton('admin_user', 'id', $value['id'], 'Admin') . '</td>';
            $data .= '<td>' . $this->showButton('block_user', 'id', $value['id'], 'Block') . '</td>';
            $data .= '</tr>';
        }
        $data .= '</table>';

        require_once($this->model->getTemplate());
    }

    public function showAllBlockedUsers()
    {
        $style = $this->model->getStylesheet();
        $menu = $this->showMenu();
        $forms[] = 'templates/logoutForm.php';

        $data = '<table>';
        $data .= '<tr><th>ID</th><th>Firstname</th><th>Lastname</th><th>Email</th><th>Member of communities</th><th>Liked posts</th></tr>';
        
        foreach($this->model->getAllBlockedUsers() as $user => $value) {
            $data .= '<tr>';
            $data .= '<td>' . $value['id'] . '</td>';
            $data .= '<td>' . $value['firstname'] . '</td>';
            $data .= '<td>' . $value['lastname'] . '</td>';
            $data .= '<td>' . $value['email'] . '</td>';
            $data .= '<td>' . $value['community_id'] . '</td>';
            $data .= '<td>' . $value['liked_post_ids'] . '</td>';
            $data .= '<td>' . $this->showButton('unblock_user', 'id', $value['id'], 'Unblock') . '</td>';
            $data .= '</tr>';
        }
        $data .= '</table>';

        require_once($this->model->getTemplate());
    }

    public function showAllPosts()
    {
        $style = $this->model->getStylesheet();
        $menu = $this->showMenu();
        $forms[] = 'templates/logoutForm.php';

        $data = '<table>';
        $data .= '<tr><th>ID</th><th>User ID</th><th>Post title</th><th>Post Concent</th><th>Posted date</th><th>Likes</th><th>Community ID</th></tr>';
        
        foreach($this->model->getAllPosts() as $post => $value) {
            $data .= '<tr>';
            $data .= '<td>' . $value['id'] . '</td>';
            $data .= '<td>' . $value['user_id'] . '</td>';
            $data .= '<td>' . $value['post_title'] . '</td>';
            $data .= '<td>' . $value['post_content'] . '</td>';
            $data .= '<td>' . $value['post_date'] . '</td>';
            $data .= '<td>' . $value['likes'] . '</td>';
            $data .= '<td>' . $value['community_id'] . '</td>';
            $data .= '<td>' . $this->showButton('delete_post', 'id', $value['id'], 'Delete') . '</td>';
            $data .= '</tr>';
        }
        $data .= '</table>';

        require_once($this->model->getTemplate());
    }

    public function showAllCommunities()
    {
        $style = $this->model->getStylesheet();
        $menu = $this->showMenu();
        $forms[] = 'templates/logoutForm.php';

        $data = '<table>';
        $data .= '<tr><th>ID</th><th>Name</th><th>image url</th></tr>';
        
        foreach($this->model->getAllCommunities() as $post => $value) {
            $image = json_decode($value['image']) ?? '';

            $data .= '<tr>';
            $data .= '<td>' . $value['id'] . '</td>';
            $data .= '<td>' . $value['name'] . '</td>';
            if($image) {
                $data .= '<td><img src="resources/images/' . $image->name . '"></td>';
            } else {
                $data .= '<td></td>';
            }
            $data .= '<td>' . $this->showButton('delete_community', 'id', $value['id'], 'Delete') . '</td>';
            $data .= '</tr>';
        }
        $data .= '</table>';

        require_once($this->model->getTemplate());
    }
}