<?php
session_start();

spl_autoload_register(function($classname) {
    $filename = 'app/'.str_replace('\\', '/', $classname).'.php';
    if (file_exists($filename)) {require_once $filename;}
});

$model = new Models\Users();
$controller = new Controllers\Users($model);
$view = new View\Users($controller, $model);

if (!isset($_SESSION['loggedIn'])) {
    $view->showLoginForm();
}

if(isset($_POST['login'])) {
    $args = [
        'action' => 'login',
        'data' => [
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ],
    ];
    
    $controller->invoke($args);

    header('Location: posts.php');
}

if (isset($_POST['register'])) {
    $args = [
        'action' => 'register user',
        'data' => [
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ],
    ];

    $controller->invoke($args);
}