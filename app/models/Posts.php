<?php
namespace Models;

class Posts extends AbstractModel {
    protected $salt = 'j4H9?s0d';
    protected $loggedInUserData;    // De data van de ingelogde gebruiker vanuit de database

    use \DatabaseTrait;

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
        if($this->checkLoginStatus()) {
            $userData = \json_decode($_SESSION['loggedInUserData']);
            $communityID = $userData->community_id;
            try {
                $stmt = $this->db->prepare("SELECT * FROM communities WHERE id = ?");
                $stmt->bindParam(1, $communityID);
                $stmt->execute();
                $stmt->setFetchMode(\PDO::FETCH_ASSOC);
                $data = [];
                while($row = $stmt->fetch()) {
                    $row['post_title'] = $row['post_title'];
                    $row['post_content'] = $row['post_content'];
                    $data[] = $row;
                }
                $this->data = $data;
                // var_dump($this->data);
            }
            catch(PDOException $e) {echo $e->getMessage();}
        }
    }

    public function getData()
    {
        return $this->data;
    }

    public function getAllUsers()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM users");
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            
            while($row = $stmt->fetch()) {
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
        $email = $args['data']['email'];
        if(!$this->checkUserExists($email)) {
            echo '<p>Email adress unknown!</p>';
            echo '<p>Please register or try another email adress.</p>';
        }
        if($args) {
            $password = md5($args['data']['password'] . $this->salt);
            try {
                $stmt = $this->db->prepare("
                    SELECT users.id, users.firstname, users.lastname, users.email, users.admin, users.community_id 
                    FROM users WHERE email = ? AND pass = ?
                ");
                $stmt->bindParam(1, $email);
                $stmt->bindParam(2, $password);
                $stmt->execute();
                $stmt->setFetchMode(\PDO::FETCH_ASSOC);
                $data = $stmt->fetch();
                
                var_dump($data);
                if($data) {
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['loggedInUserData'] = \json_encode($data);
                    
                    $this->loggedInUserData = \json_encode($data);
                    var_dump('json: ' . $this->loggedInUserData);

                    return true;
                } else {
                    $this->logout();
                    return false;
                }
            } catch(PDOException $e) {
                echo $e->getMessage("ERROR: Could not prepare MySQLi statement.");
            }
        }
    }

    public function checkLoginStatus()
    {
        if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
            return true;
        } else {
            return false;
        }
    }

    public function logout()
    {
        session_destroy();
        session_start();
    }

    public function registerUser($args)
    {
        $email = $args['data']['email'];
        $password = md5($args['data']['password'] . $this->salt);
        
        if(!$this->checkUserExists($email)) {
            try {
                $stmt = $this->db->prepare("
                    INSERT INTO users (firstname, lastname, pass, email) 
                    VALUES (?, ?, ?, ?)
                ");
                $stmt->bindParam(1, $args['data']['firstname']);
                $stmt->bindParam(2, $args['data']['lastname']);
                $stmt->bindParam(3, $password);
                $stmt->bindParam(4, $email);
                $stmt->execute();
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
            // var_dump($data);
            if(!empty($data)) {
                return true;
            } else {
                return false;
            }
        } catch(PDOException $e) {
            echo $e->getMessage("ERROR: Could not prepare MySQLi statement.");
        }
    }

    public function submitPost($args)
    {
        $loggedInUserData = json_decode($_SESSION['loggedInUserData']);
        $postDate = $this->getDateAndTime();
        try {
            $stmt = $this->db->prepare("
                INSERT INTO posts (user_id, post_title, post_content, post_date, community_id) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->bindParam(1, $loggedInUserData->id);
            $stmt->bindParam(2, $args['data']['title']);
            $stmt->bindParam(3, $args['data']['content']);
            $stmt->bindParam(4, $postDate);
            $stmt->bindParam(5, $loggedInUserData->community_id);
            $stmt->execute();
        } catch(PDOException $e) {
            echo $e->getMessage("ERROR: Could not prepare MySQLi statement.");
        }
    }

    public function getDateAndTime()
    {
        $today = date('d-m-Y');
        $time = date('H:i:s');
        
        return $today . '/' . $time;
    }
}