<form action="<?= $controller->url_for('auth/register') ?>" method="post">
    <fieldset>
        <legend>Als Nutzer registrieren</legend>

        <div class="type-text">
            <label for="nickname">Nutzername</label>
            <input type="text" required name="nickname" id="nickname" value="<?= @$_POST['nickname'] ?: '' ?>">
        </div>

        <div class="type-text">
            <label for="email">eMail</label>
            <input type="email" required name="email" id="email" value="<?= @$_POST['email'] ?: '' ?>">
        </div>

        <div class="type-text">
            <label for="password">Passwort</label>
            <input type="password" required name="password" id="password" pattern=".{6,}" title="Mindestens 6 Zeichen">
        </div>

        <div class="footer">
            <button type="submit" class="accept button">Registrieren</button>
        </div>
    </fieldset>
</form>