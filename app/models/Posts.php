<?php
namespace Models;

class Posts extends AbstractModel {
    protected $salt = 'j4H9?s0d';

    use \DatabaseTrait;

    /**
     * Get all posts from database
     */
    public function getAllPosts() 
    {
        try {
            $ps = $this->db->query("SELECT * FROM posts");
            $ps->setFetchMode(\PDO::FETCH_ASSOC);
            $data = [];
            while($row = $ps->fetch()) {
                // var_dump($row);
                $row['post_title'] = $row['post_title'];
                $data[] = $row;
            }
            $this->data = $data;
            // var_dump($data);
        }
        catch(PDOException $e) {echo $e->getMessage();}
    }

    public function getPostsByCommunity()
    {
        $this->data = 'posts by community';
    }

    // public function getTemplate() {
    //     return parent::getTemplate();
    // }
    
    // public function getStylesheet() {
    //     return parent::getStylesheet();
    // }

    public function getData() 
    {
        return $this->data;
    }

    public function getUsers()
    {
        try {
            $ps = $this->db->query("SELECT * FROM users");
            $ps->setFetchMode(\PDO::FETCH_ASSOC);
            
            while($row = $ps->fetch()) {
                // var_dump($row);
                $data = [
                    'id' => $row['id'],
                    'firstname' => $row['firstname'],
                    'lastname' => $row['lastname'],
                    'username' => $row['username'],
                    'password' => $row['password'],
                    'email' => $row['email'],
                    'admin' => $row['admin'],
                ];
            }
            return $data;
            var_dump($data);
        }
        catch(PDOException $e) {echo $e->getMessage();}
    }

    public function validateLogin($user, $pass)
    {
        if($stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? AND password = ?")) {
            $stmt->bind_param('ss', $user, md5($pass . $this->salt));
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows > 0) {
                $stmt->close();
                return true;
            } else {
                $stmt->close();
                return false;
            }
        } else {
            die("ERROR: Could not prepare MySQLi statement.");
        }
    }
}