<?php
// if(isset($_POST['login'])) {
//     $args = [
//         'action' => 'login',
//         'data' => [
//             'email' => $_POST['email'],
//             'password' => $_POST['password'],
//         ],
//     ];
    
//     $controller->invoke($args);
// }
?><form id="login_form" action="" method="POST" enctype="multipart/form-data">
    <fieldset><legend>Inloggen</legend>
        <label>Email: <input type="text" name="email" required></label>
        <label>Password: <input type="password" name="password" required></label>
        <input type="submit" name="login" value="Login">
    </fieldset>
</form>