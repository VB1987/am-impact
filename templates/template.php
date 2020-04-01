<?php
    $data = $data ?? false;
    $form = $form ?? false;
?><!DOCTYPE html>
<html lang="en_EN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A&M Impact opdracht</title>
    <link type="text/css" rel="stylesheet" href="<?=$style?>">
</head>
<body>
    <div class="container">
        <div class="header"></div>
        <div class="data">
            <?=$data?>
        </div>
        <!-- <div class="form">
            <?php //$form?>
        </div> -->
    </div>
</body>
</html>