<?
    $navigation = array(
        'welcome/index' => 'Startseite',
    );

    if (!Auth::User()) {
        $navigation['auth/register'] = 'Registrieren';
    } else {
        $navigation['lookup/search']       = 'Suche';
        $navigation['products/categories'] = 'Produkte';
    }
?>

<!DOCTYPE html>
<html>
<head>
    <base href="<?= $controller->url_for('') ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>EAN Lookup</title>
    <link rel="stylesheet/less" type="text/css" href="assets/styles.less">
    <script src="assets/less-1.3.3.min.js" type="text/javascript"></script>
</head>
<body>
    <div class="canvas">
        <header>
            EAN Lookup
        </header>
        <nav class="main">
            <section class="user-area">
            <? if (Auth::User()): ?>
                Eingeloggt als
                <a href="<?= $controller->url_for('account', Auth::User()->nickname) ?>">
                    <?= Auth::User()->nickname ?>
                </a>
                |
                <a href="<?= $controller->url_for('auth/logout') ?>">
                    Logout
                </a>
            <? else: ?>
                <form action="<?= $controller->url_for('auth/login') ?>" method="post">
                    <input type="text" name="nickname" placeholder="Nickname or eMail">
                    <input type="password" name="password" placeholder="Password">
                    <input type="submit" value="Login">
                </form>
            <? endif; ?>
            </section>

            <ul>
            <? foreach ($navigation as $path => $label): ?>
                <li>
                    <a href="<?= $controller->url_for($path) ?>">
                        <?= $label ?>
                    </a>
                </li>
            <? endforeach; ?>
            </ul>
        </nav>
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