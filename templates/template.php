<?php
    $data = $data ?? false;
    $postForm = $postForm ?? false;
    $loginForm = $loginForm ?? false;
?><!DOCTYPE html>
<html lang="en_EN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A&M Impact opdracht</title>
    <link type="text/css" rel="stylesheet" href="<?=$style?>">
</head>
<body>
    <?php //if ($loggedIn) : ?>
    <?=$loginForm?>
    <?=$data?>
    <?=$postForm?>
    <!-- <div>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="post_title"></label><input type="text" name="post_title">
            <label for="post_content"></label><input type="text" name="post_content">
        </form>
    </div> -->
    <?php //else : ?>
        <!-- <form action="" method="POST" enctype="multipart/form-data">
            <fieldset><legend>Inlog gegevens</legend>
                <label>Username: <input type="text" name="username"></label>
                <label>Password: <input type="password" name="password"></label>
                <input type="submit" value="Inloggen">
            </fieldset>
        </form> -->
    <?php //endif; ?>
</body>
</html>