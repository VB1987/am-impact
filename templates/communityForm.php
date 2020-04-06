<?php

?><form id="community_form" action="" method="POST" enctype="multipart/form-data">
    <fieldset><legend>Create a community</legend>
        <label for="community_name">Title: </label><input type="text" name="community_name" required>
        <br>
        <label for="community_image">Image: </label><input type="file" name="community_image">
        <br>
        <input type="submit" name="create_community" value="Create community">
    </fieldset>
</form>