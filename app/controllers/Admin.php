<?php
namespace Controllers;

class Admin extends AbstractController {

    
    public function allUsers()
    {
        $this->model->getAllUsers();     
    }

    public function allPosts()
    {
        $this->model->getAllPosts();
    }

    public function allCommunities() 
    {
        $this->model->getAllCommunities();
    }

    public function update($action, $id)
    {
        if($action === 'delete_post') {
            $this->model->deletePost($id);
        }
        if($action === 'block_user') {
            $this->model->blockUser($id);
        }
        if($action === 'unblock_user') {
            $this->model->unblockUser($id);
        }
        if($action === 'delete_community') {
            $this->model->deleteCommunity($id);
        }
    }
}