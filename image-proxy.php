<?php
    require_once 'classes/Cache.php';

    if (mt_rand(1, 10) == mt_rand(1, 10)) {
        Cache::Purge();
    }

    $image = $_REQUEST['image'];
    $hash  = md5($image);

    $content = Cache::find($hash, 'jpg', function () use ($image) {
        $remote = file_get_contents($image);
        $image  = imagecreatefromstring($remote);

        ob_start();
        imagejpeg($image, null);
        return ob_get_clean();
    });

    if (isset($_REQUEST['size'])) {
        list($width, $height) = @explode($_REQUEST['size'], 'x', 2);
        // TODO: Implement resizing
    }

    header('Content-Type: image/jpeg');
    echo $content;
