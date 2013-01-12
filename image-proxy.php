<?php
    require_once 'classes/Cache.php';

    if (mt_rand(1, 10) == mt_rand(1, 10)) {
        Cache::Purge();
    }

    $image   = $_REQUEST['image'];
    $hash    = md5($image);

    $content = Cache::find($hash, 'jpeg', function () use ($image) {
        $remote = file_get_contents($image);
        $image  = imagecreatefromstring($remote);

        ob_start();
        imagejpeg($image, null, 90);
        return ob_get_clean();
    });
    
    header('Content-Type: image/jpeg');
    echo $content;
