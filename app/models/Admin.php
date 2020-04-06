<?php
namespace Models;

class Admin extends AbstractModel {

    use \DatabaseTrait;

    private $adminDb;
    private $adminData;

    /**
     * Get all posts from database
     */
    public function getAllPosts() 
    {
        try {
            $stmt = $this->db->query("SELECT * FROM posts");
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            $data = [];
            while($row = $stmt->fetch()) {
                $data[] = $row;
            }
            return $data;
        }
        catch(PDOException $e) {echo $e->getMessage();}
    }

    public function getAllUsers()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM users");
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            
            $data = [];
            while($row = $stmt->fetch()) {
                $data[] = $row;
            }
            return $data;
        }
        catch(PDOException $e) {echo $e->getMessage();}
    }

    public function getAllBlockedUsers()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM users WHERE users.blocked = 1");
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            
            $data = [];
            while($row = $stmt->fetch()) {
                $data[] = $row;
            }
            return $data;
        }
        catch(PDOException $e) {echo $e->getMessage();}
    }

    public function deletePost($id)
    {
        try {
            $stmt = $this->db->prepare("
                DELETE FROM posts
                WHERE posts.id = ?
            ");
            $stmt->bindParam(1, $id);
            $stmt->execute();
        }
        catch(PDOException $e) {echo $e->getMessage();}
    }

    public function deleteCommunity($id)
    {
        try {
            $stmt = $this->db->prepare("
                DELETE FROM communities
                WHERE communities.id = ?
            ");
            $stmt->bindParam(1, $id);
            $stmt->execute();
        }
        catch(PDOException $e) {echo $e->getMessage();}
    }

    public function blockUser($id)
    {
        try {
            $user = $this->db->prepare("
                SELECT users.admin FROM users
                WHERE users.id = ?
            ");
            $user->bindParam(1, $id);
            $user->execute();
            $data = [];
            while($row = $user->fetch()) {
                $data[] = $row;
            }
        }
        catch(PDOException $e) {echo $e->getMessage();}
        
        if($data[0]['admin'] === '1') {
            return 'Users is admin and cannot be blocked!';
        }
        try {
            $stmt = $this->db->prepare("
                UPDATE users
                SET blocked = 1
                WHERE users.id = ?
            ");
            $stmt->bindParam(1, $id);
            $stmt->execute();
        }
        catch(PDOException $e) {echo $e->getMessage();}
    }

    public function adminUser($id)
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE users
                SET admin = 1
                WHERE users.id = ?
            ");
            $stmt->bindParam(1, $id);
            $stmt->execute();
        }
        catch(PDOException $e) {echo $e->getMessage();}
    }

    public function unblockUser($id)
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE users
                SET blocked = 0
                WHERE users.id = ?
            ");
            $stmt->bindParam(1, $id);
            $stmt->execute();
        }
        catch(PDOException $e) {echo $e->getMessage();}
    }
}