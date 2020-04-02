<?php
namespace View;

abstract class AbstractView
{
    protected $model;
    protected $controller;
    protected $style;
    protected $menu;
    
    final public function __construct($controller, $model) 
    {
        $this->model = $model;
        $this->controller = $controller;

        $this->style = $this->model->getStylesheet();

        // $this->menu = $this->showMenu();
    }

    public function showMenu()
    {
        $menuItems = $this->model->getMenu();
        // var_dump($menuItems);
        $data = '<form id="menu_form" action="" method="GET">';
        $data .= '<fieldset><legend>Options</legend>';
        foreach($menuItems as $item) {
            $data .= '<button href="' . '' . '" target="" name="' . $item['name'] . '" value="' . $item['value'] . '">' . $item['text'] . '</button>';
        }
        $data .= '</fieldset>';
        $data .= '</form>';

        return $data;
    }

    public function showButtons($action, $name, $value, $text)
    {
        $buttons = '<form id="menu_form" url="" method="POST" enctype="multipart/form-data">';
        $buttons .= '<button name="' . $name . '" value="' . $value . '">' . $text . '</button>';
        $buttons .= '<input type="hidden" name="action" value="' . $action . '">';
        $buttons .= '</form>';

        return $buttons;
    }
}
