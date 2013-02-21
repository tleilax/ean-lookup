<h1>Login</h1>
<form action="<?= $controller->url_for('auth/login') ?>" method="post" class="form-horizontal">
<? if ($return_to): ?>
    <input type="hidden" name="return_to" value="<?= $return_to ?>">
<? endif; ?>
    <div class="control-group">
        <label class="control-label" for="nickname">Nickname / eMail</label>
        <div class="controls">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-user"></i></span>
                <input type="text" autofocus required name="nickname" id="nickname" value="<?= @$_POST['nickname'] ?: '' ?>">
            </div>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="password">Passwort</label>
        <div class="controls">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-lock"></i></span>
                <input type="password" required name="password" id="password">
            </div>
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <label class="checkbox">
                <input type="checkbox" name="remember-me">
                Eingeloggt bleiben
            </label>
            <button type="submit" class="btn">Login</button>
        </div>
    </div>
</form>
