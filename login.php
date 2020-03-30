<?php
session_start();

spl_autoload_register(function($classname) {
    $filename = 'app/'.str_replace('\\', '/', $classname).'.php';
    if (file_exists($filename)) {require_once $filename;}
});

if($_POST['login']) {
    $args = [
        'action' => 'login',
        'data' => [
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ],
    ];
    
    $controller->invoke($args);
} elseif ($_POST['register']) {
    $view->showForm('registerForm.php');
}
?><form id="login_form" action="" method="POST" enctype="multipart/form-data">
    <fieldset><legend>Inlog gegevens</legend>
        <label>Email: <input type="text" name="email" required></label>
        <label>Password: <input type="password" name="password" required></label>
        <input type="submit" name="login" value="Login">
    </fieldset>
</form>
<form id="register_form" action="" method="POST" enctype="multipart/form-data">
    <fieldset>
        <input type="submit" name="register" value="Register">
    </fieldset>
</form>