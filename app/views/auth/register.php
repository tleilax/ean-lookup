<h1>Als Nutzer registrieren</h1>
<form action="<?= $controller->url_for('auth/register') ?>" method="post" class="form-horizontal">
    <div class="control-group">
        <label class="control-label" for="nickname">Nutzername</label>
        <div class="controls">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-user"></i></span>
                <input type="text" required name="nickname" id="nickname" value="<?= @$_POST['nickname'] ?: '' ?>">
            </div>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="email">eMail</label>
        <div class="controls">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-envelope"></i></span>
                <input type="email" required name="email" id="email" value="<?= @$_POST['email'] ?: '' ?>">
            </div>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="password">Passwort</label>
        <div class="controls">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-lock"></i></span>
                <input type="password" required name="password" id="password" pattern=".{6,}" title="Mindestens 6 Zeichen">
            </div>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Registrieren</button>
        <a class="btn" href="<?= $controller->url_for('') ?>">Abbrechen</a>
    </div>
</form>