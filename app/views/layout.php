<!DOCTYPE html>
<html>
<head>
    <base href="/~tleilax/ean-lookup/">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EAN Lookup</title>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link href="assets/styles.min.css" rel="stylesheet" type="text/css">
<?/*
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
*/?>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
<body>
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a href="<?= $controller->url_for('') ?>" class="brand">
                    EAN Lookup
                </a>
                <ul class="nav">
                    <li>
                <? foreach ($navigations['primary'] as $path => $action): ?>
                    <li <? if (strpos($request_uri, $action['action']) !== false) echo 'class="active"'; ?>>
                        <a href="<?= $controller->url_for($action['action']) ?>">
                        <? if ($action['icon']): ?>
                            <i class="icon-<?= $action['icon'] ?>"></i>
                        <? endif; ?>
                            <?= $action['label'] ?>
                        </a>
                    </li>
                <? endforeach; ?>
                </ul>
                <ul class="nav pull-right">
                <? foreach ($navigations['secondary'] as $path => $action): ?>
                    <li <? if (strpos($request_uri, $action['action']) !== false) echo 'class="active"'; ?>>
                        <a href="<?= $controller->url_for($action['action']) ?>">
                        <? if ($action['icon']): ?>
                            <i class="icon-<?= $action['icon'] ?>"></i>
                        <? endif; ?>
                            <?= $action['label'] ?>
                        </a>
                    </li>
                <? endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
    <? foreach ($messages as $message): ?>
        <div class="alert <? if ($message['type'] !== 'warning') echo 'alert-' . $message['type']; ?>">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= nl2br($message['message']) ?>
        </div>            
    <? endforeach; ?>
        <?= $content_for_layout . "\n" ?>
    </div>

    <div id="footer">
        <div class="container">
            &copy; 2013
            <? if (date('Y') > 2013) echo ' - ' . date('Y') ?>
            by <a href="http://tleilax.de">tleilax</a>
        </div>
    </div>
<?/*
    <script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
*/?>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
    <script src="assets/application.min.js"></script>
</body>
</html>