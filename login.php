<?php
session_start();

spl_autoload_register(function($classname) {
    $filename = 'app/'.str_replace('\\', '/', $classname).'.php';
    if (file_exists($filename)) {require_once $filename;}
});

$model = new Models\Posts();
$controller = new Controllers\Posts($model);
$view = new View\Posts($controller, $model);

if(isset($_POST['login'])) {
    $args = [
        'action' => 'login',
        'data' => [
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ],
    ];
    
    $controller->invoke($args);
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

include_once 'templates/loginForm.php';
include_once 'templates/registerForm.php';