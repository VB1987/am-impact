<?php
// if (isset($_POST['register'])) {
//     $args = [
//         'action' => 'register user',
//         'data' => [
//             'firstname' => $_POST['firstname'],
//             'lastname' => $_POST['lastname'],
//             'email' => $_POST['email'],
//             'password' => $_POST['password'],
//         ],
//     ];

//     $controller->invoke($args);
// }
?><form id="register_form" action="" method="POST" enctype="multipart/form-data">
    <fieldset><legend>Registeren</legend>
        <label for="firstname">Firstname: <input type="text" name="firstname" required></label>
        <label for="firstname">Lastname: <input type="text" name="lastname" required></label>
        <label for="firstname">Email: <input type="email" name="email" required></label>
        <label for="firstname">Password: <input type="password" name="password" required></label>
        <input type="submit" value="Register" name="register">
        <input type="reset" value="Reset" name="reset">
    </fieldset>
</form>