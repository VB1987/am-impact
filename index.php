<?php
session_start();

spl_autoload_register(function($classname) {
    $filename = 'app/'.str_replace('\\', '/', $classname).'.php';
    if (file_exists($filename)) {require_once $filename;}
});

$model = new Models\Posts();
$controller = new Controllers\Posts($model);
$view = new View\Posts($controller, $model);

$loggedIn = $_SESSION['loggedIn'] ?? false;
var_dump($loggedIn);
if ($loggedIn) {
    $controller->allPosts();
    $view->showAllPosts();
} else {
    // $view->showForm('loginForm.php');
    include_once 'templates/loginForm.php';
    include_once 'templates/registerForm.php';
}