<?php
session_start();

spl_autoload_register(function($classname) {
    $filename = 'app/'.str_replace('\\', '/', $classname).'.php';
    if (file_exists($filename)) {require_once $filename;}
});

$model = new Models\Admin();
$controller = new Controllers\Admin($model);
$view = new View\Admin($controller, $model);

$args = [
    ['text' => 'Posts', 'url' => '', 'target' => '_self', 'name' => 'page', 'value' => 'posts'],
    ['text' => 'Users', 'url' => '', 'target' => '_self', 'name' => 'page', 'value' => 'users'],
    ['text' => 'Blocked users', 'url' => '', 'target' => '_self', 'name' => 'page', 'value' => 'blocked_users'],
    ['text' => 'Communities', 'url' => '', 'target' => '_self', 'name' => 'page', 'value' => 'communities'],
];
$controller->menu($args);

if (isset($_SESSION['loggedIn']) && $_SESSION['admin']) {
    if (isset($_GET['page'])) {
        if ($_GET['page'] === 'users') {
            $view->showAllUsers();
        }
        if ($_GET['page'] === 'blocked_users') {
            $view->showAllBlockedUsers();
        }
        if ($_GET['page'] === 'posts') {
            $view->showAllPosts();
        }
        if ($_GET['page'] === 'communities') {
            $view->showAllCommunities();
        }
    } else {
        $view->showAllUsers();
    }

    // var_dump($_POST);
    if (isset($_POST['action']) && isset($_POST['id'])) {
        $controller->update($_POST['action'], $_POST['id']);
    }

} else {
    header('Location: login.php');
}

if (isset($_POST['logout'])) {
    $controller->sessionDestroy();
    header('Location: login.php');
}