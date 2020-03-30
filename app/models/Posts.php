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
            // var_dump($data);
        }
        catch(PDOException $e) {echo $e->getMessage();}
    }

    public function validateLogin($args)
    {
        if($args) {
            $email = $args['data']['email'];
            $password = md5($args['data']['password'] . $this->salt);
            try {
                $stmt = $this->db->prepare("SELECT users.id, users.firstname, users.lastname, users.email, users.admin FROM users WHERE email = ? AND pass = ?");
                $stmt->bindParam(1, $email);
                $stmt->bindParam(2, $password);
                $stmt->execute();
                $stmt->setFetchMode(\PDO::FETCH_ASSOC);
                $data = $stmt->fetch();
                
                if($data) {
                    $_SESSION['loggedIn'] = true;
                    return true;
                } else {
                    $this->logOut();
                    return false;
                }
            } catch(PDOException $e) {
                echo $e->getMessage("ERROR: Could not prepare MySQLi statement.");
            }
        }
    }

    public function checkLoginStatus()
    {
        if(isset($_SESSION['loggedIn'])) {
            return true;
        } else {
            return false;
        }
    }

    public function logOut()
    {
        session_destroy();
        session_start();
    }

    public function registerUser($args)
    {
        $email = $args['data']['email'];
        $password = md5($args['data']['password'] . $this->salt);
        
        if($this->checkUserExists($email)) {
            try {
                $stmt = $this->db->prepare("INSERT INTO users (firstname, lastname, pass, email) VALUES (?, ?, ?, ?)");
                $stmt->bindParam(1, $args['data']['firstname']);
                $stmt->bindParam(2, $args['data']['lastname']);
                $stmt->bindParam(3, $password);
                $stmt->bindParam(4, $email);
                $stmt->execute();
                
                if($data) {
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e) {
                echo $e->getMessage("ERROR: Could not prepare MySQLi statement.");
            }
        } else {
            echo 'This email adress is already registered!';
        }
    
    }

    public function checkUserExists($email)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bindParam(1, $email);
            $stmt->execute();
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            $data = $stmt->fetch();
        } catch(PDOException $e) {
            echo $e->getMessage("ERROR: Could not prepare MySQLi statement.");
        }
    }
}