<?php
namespace Models;

class Users extends AbstractModel {
    protected $salt = 'j4H9?s0d';

    use \DatabaseTrait;

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
                    FROM users WHERE users.email = ? AND users.pass = ?
                ");
                $stmt->bindParam(1, $email);
                $stmt->bindParam(2, $password);
                $stmt->execute();
                $stmt->setFetchMode(\PDO::FETCH_ASSOC);
                $data = $stmt->fetch();
                
                if($data) {
                    $_SESSION['loggedIn'] = true;
                    if($data['admin'] == '1') {
                        $_SESSION['admin'] = true;
                    }
                    $_SESSION['userData'] = \json_encode($data);
                    
                    return true;
                } else {
                    $this->sessionDestroy();
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
            $userData = json_decode($_SESSION['userData']);
            
            if($_SESSION['loggedIn'] === true && $userData->admin == 1) {
                return 'admin';
            } elseif($_SESSION['loggedIn'] === true && $userData->admin == 0) {
                return true;
            } else {
                return false;
            }
        }
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
            
            if(!empty($data)) {
                return true;
            } else {
                return false;
            }
        } catch(PDOException $e) {
            echo $e->getMessage("ERROR: Could not prepare MySQLi statement.");
        }
    }
}
