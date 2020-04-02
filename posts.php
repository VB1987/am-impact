<?php
session_start();

spl_autoload_register(function($classname) {
    $filename = 'app/'.str_replace('\\', '/', $classname).'.php';
    if (file_exists($filename)) {require_once $filename;}
});

$model = new Models\Posts();
$controller = new Controllers\Posts($model);
$view = new View\Posts($controller, $model);

$args = [
    ['text' => 'Posts', 'url' => '', 'target' => '_self', 'name' => 'page', 'value' => 'posts'],
    ['text' => 'Communities', 'url' => '', 'target' => '_self', 'name' => 'page', 'value' => 'communities'],
];
$controller->menu($args);

// $model->sessionDestroy();
var_dump($_POST);
if (isset($_SESSION['admin'])) {
    header('Location: admin.php');
}
if (isset($_SESSION['loggedIn'])) {
    if (isset($_GET['page'])) {
        if ($_GET['page'] === 'posts') {wAllPosts();
            $controller->PostsByCommunity();
            $view->showCommunityPosts();
        }
        if ($_GET['page'] === 'communities') {
            $view->showAllCommunities();
        }
    } else {
        $controller->PostsByCommunity();
        $view->showCommunityPosts();
    }

    if (isset($_POST['action']) && isset($_POST['id'])) {
        $controller->update($_POST['action'], $_POST['id']);
    }
} else {
    header('Location: login.php');
}

if (isset($_POST['submit_post'])) {
    $args = [
        'action' => 'submit post',
        'data' => [
            // 'user_id' => $_SESSION['userId'],
            'title' => $_POST['post_title'],
            'content' => $_POST['post_content'],
        ],
    ];

    $controller->invoke($args);
}
if (isset($_POST['logout'])) {
    $controller->sessionDestroy();
    header('Location: login.php');
}
