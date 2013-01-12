<!DOCTYPE html>
<html>
<head>
    <base href="<?= $controller->url_for('') ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>EAN Lookup</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>
    <div class="canvas">
        <header>
            EAN Lookup
        </header>
        <div class="mainstage">
            <?= $content_for_layout . "\n" ?>
        </div>
        <footer>
            &copy; 2013
            <? if (date('Y') > 2013) echo ' - ' . date('Y') ?>
            by <a href="http://tleilax.de">tleilax</a>
        </footer>
    </div>
</body>
</html>