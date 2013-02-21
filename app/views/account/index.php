<h3>account</h3>

<form action="<?= $controller->url_for('account/password') ?>" method="post">
    <fieldset>
        <legend>Passwort ändern</legend>
        
        <div>
            <label for="password">Aktuelles Passwort</label>
            <input required type="password" name="password" id="password">
        </div>
        
        <div>
            <label for="new">Neues Passwort</label>
            <input required type="password" name="new" id="new">
        </div>
    </fieldset>
</form>