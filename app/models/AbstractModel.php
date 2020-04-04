<?php
namespace Models;

abstract class AbstractModel {
    protected $db; 				    // De actieve databaseconnectie
    protected $data;			    // De opgehaalde data
    protected $template; 		    // De template die ingeladen moet worden
    protected $stylesheet; 		    // De stylesheet die ingeladen moet worden
    protected $menu;                // De menu items

    use \DatabaseTrait;

    final public function __construct()
    {
        $this->db = \DatabaseTrait::makeConnection();
        $this->template = 'templates/template.php';
        $this->stylesheet = 'css/style.css';
    }

    public function getStylesheet()
    {
        return $this->stylesheet;
    }

    public function getTemplate() 
    {
        return $this->template;
    }

    public function getData() 
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getDate()
    {
        return date('d-m-Y');
    }

    public function getTime()
    {
        return date('H:i:s');
    }

    public function sessionDestroy()
    {
        session_destroy();
        session_start();
    }

    public function setMenu($args)
    {
        $this->menu = $args;
    }
    
    public function getMenu()
    {
        return $this->menu;
    }

    public function getAllCommunities()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM communities");
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            
            $data = [];
            while($row = $stmt->fetch()) {
                $data[] = $row;
            }
            return $data;
        }
        catch(PDOException $e) {echo $e->getMessage();}
    }

    public function getLoggedInUserId()
    {
        $userData = \json_decode($_SESSION['userData']);
        $userId = $userData->id;

        return $userId;
    }
}