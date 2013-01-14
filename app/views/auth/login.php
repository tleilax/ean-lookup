<form action="<?= $controller->url_for('auth/login') ?>" method="post">
<? if ($return_to): ?>
    <input type="hidden" name="return_to" value="<?= $return_to ?>">
<? endif; ?>
    <input type="text" name="nickname" placeholder="Nickname or eMail">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" value="Login">
</form>
