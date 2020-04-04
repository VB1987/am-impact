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
    ['text' => 'All Communities', 'url' => '', 'target' => '_self', 'name' => 'page', 'value' => 'communities'],
];

$controller->menu($args);

// $model->sessionDestroy();
// var_dump($_SESSION);
// var_dump($_GET);
if (isset($_SESSION['admin'])) {
    header('Location: admin.php');
}
if (isset($_SESSION['loggedIn'])) {
    if (isset($_GET['page'])) {
        if ($_GET['page'] === 'posts') {
            $controller->PostsByCommunity();
            $view->showCommunityPosts();
        }
        if ($_GET['page'] === 'communities') {
            $view->showAllCommunities();
        }
        else {
            $controller->PostsByCommunity();
            $view->showCommunityPosts();
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
    if(!empty($_POST['post_title']) && !empty($_POST['post_content'])) {
        $args = [
            'action' => 'submit post',
            'data' => [
                // 'user_id' => $_SESSION['userId'],
                'title' => $_POST['post_title'],
                'content' => $_POST['post_content'],
                'community id' => $_POST['select_community'],
            ],
        ];

        $controller->invoke($args);
    }
}
if (isset($_POST['logout'])) {
    $controller->sessionDestroy();
    header('Location: login.php');
}

