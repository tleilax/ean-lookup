<?php
    require_once 'classes/Cache.php';

    if (mt_rand(1, 10) == mt_rand(1, 10)) {
#        Cache::Purge();
    }

    $image = $_REQUEST['image'];
    $hash  = md5($image);

    $content = Cache::find($hash, 'jpg', function () use ($image) {
        $remote = file_get_contents($image);
        $image  = imagecreatefromstring($remote);

        ob_start();
        imagejpeg($image, null, 90);
        imagedestroy($image);
        return ob_get_clean();
    });

    if (!empty($_REQUEST['size'])) {
        list($width, $height) = @explode('x', $_REQUEST['size'], 2);
        if (!$height) {
            $height = $width;
        }

        $hash = md5($image . '#' . $width . '#' . $height);
        $content = Cache::find($hash, 'jpg', function () use ($content, $width, $height) {
            $source = imagecreatefromstring($content);
            $w = $x = imagesx($source);
            $h = $y = imagesy($source);

            if ($w <= $width && $h <= $height) {
                return $content;
            }

            if ($w > $width) {
                $h = $h * $width / $w;
                $w = $width;
            }
            if ($h > $height) {
                $w = $w * $height / $h;
                $h = $height;
            }
            $w = floor($w);
            $h = floor($h);

            $destination = imagecreatetruecolor($w, $h);
            imagecopyresampled($destination, $source, 0, 0, 0, 0, $w, $h, $x, $y);
            imagedestroy($source);

            ob_start();
            imagejpeg($destination, null, 90);
            imagedestroy($destination);
            return ob_get_clean();
        });
    }

    header('Content-Type: image/jpeg');
    echo $content;
