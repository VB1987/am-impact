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
        <label for="post_title">Title: </label><input type="text" name="post_title" required>
        <br>
        <br>
        <label for="post_content">Content: </label><textarea name="post_content" rows="10" cols="60" required></textarea>
        <br>
        <br>
        <label for="select_community">Select community to post to: </label>
        <select name="select_community" id="">
            <option value="" disabled selected> - Select community</option>
            <?php foreach($communities as $community) : ?>
                <option value="<?=$community['id']?>"><?=$community['name']?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <br>
        <input type="submit" name="submit_post" value="Submit post">
    </fieldset>
</form>