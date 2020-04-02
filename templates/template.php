<?php
    $header = $header ?? false;
    $menu = $menu ?? false;
    $footer = $footer ?? false;
    $data = $data ?? false;
    $forms = $forms ?? [];
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
        <div class="header"><?=$header?></div>
        <div class="nav"><?=$menu?></div>
        <div class="data">
            <?=$data?>
        </div>
        <div class="form">
            <?php foreach($forms as $form) {
                include $form;
            }?>
        </div>
        <div class="footer"><?=$footer?></div>
    </div>
</body>
</html>