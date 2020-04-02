<?php
// if (isset($_POST['submit_post'])) {
//     $args = [
//         'action' => 'submit post',
//         'data' => [
//             // 'user_id' => $_SESSION['userId'],
//             'title' => $_POST['post_title'],
//             'content' => $_POST['post_content'],
//         ],
//     ];

//     $controller->invoke($args);
// }
?><form id="post_form" action="" method="POST" enctype="multipart/form-data">
    <fieldset><legend>Plaats een post</legend>
        <label for="post_title">Title: </label><input type="text" name="post_title">
        <br>
        <label for="post_content">Content: </label><textarea name="post_content" rows="10" cols="60"></textarea>
        <input type="submit" name="submit_post" value="Submit post">
    </fieldset>
</form>