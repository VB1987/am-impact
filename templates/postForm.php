<form id="post_form" action="" method="POST" enctype="multipart/form-data">
    <fieldset><legend>Add new post</legend>
        <label for="post_title">Title: </label><input type="text" name="post_title" required>
        <br>
        <br>
        <label for="post_content">Content: </label><textarea name="post_content" rows="10" cols="60" required></textarea>
        <br>
        <br>
        <label for="select_community">Select community to post to: </label>
        <select name="select_community" required>
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