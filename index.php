<?php
session_start();

spl_autoload_register(function($classname) {
    $filename = 'app/'.str_replace('\\', '/', $classname).'.php';
    if (file_exists($filename)) {require_once $filename;}
});

$model = new Models\Posts();
$controller = new Controllers\Posts($model);
$view = new View\Posts($controller, $model);

// $model->logout();
var_dump($_SESSION);
if ($model->checkLoginStatus()) {
    $controller->PostsByCommunity();
    $view->showCommunityPosts();
    include 'templates/postForm.php';
} else {
    include 'templates/loginForm.php';
    include 'templates/registerForm.php';
}

$model->getDateAndTime();