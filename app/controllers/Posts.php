<?php
namespace Controllers;

class Posts extends AbstractController {

    public function allPosts()
    {
        $this->model->getAllPosts();
    }

    public function PostsByCommunity()
    {
        $this->model->getPostsByCommunity();
    }

    public function update($action, $id)
    {
        if($action === 'join_community') {
            $this->model->joinCommunity($id);
        }
        if($action === 'leave_community') {
            $this->model->leaveCommunity($id);
        }
    }

}