<?php
namespace Models;

abstract class AbstractModel {
    protected $db; 				// De actieve databaseconnectie
    protected $data;				// De opgehaalde data
    protected $template; 		    // De template die ingeladen moet worden
    protected $stylesheet; 		// De stylesheet die ingeladen moet worden

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
}