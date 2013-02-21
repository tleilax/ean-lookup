<form action="<?= $controller->url_for('categories/store', isset($category) ? $category->id : null) ?>" method="post" class="form-horizontal">
    <fieldset>
        <legend>
        <? if (isset($category)): ?>
            Kategorie <?= htmlReady($category->name) ?> bearbeiten
        <? else: ?>
            Neue Produktkategorie
        <? endif; ?>
        </legend>

        <div class="control-group">
            <label class="control-label" for="name">Name</label>
            <div class="controls">
                <input type="text" autofocus required class="input-block-level"
                       name="name" id="name" value="<?= htmlReady(@$_POST['name'] ?: (isset($category) ? $category->name : '')) ?>">
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="description">Beschreibung</label>
            <div class="controls">
                <textarea class="input-block-level" name="description" id="description" rows="5"
                ><?= htmlReady(@$_POST['descripton'] ?: (isset($category) ? $category->description : '')) ?></textarea>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="parent">Oberkategorie</label>
            <div class="controls">
                <select name="parent" id="parent" class="input-block-level">
                    <option value="" class="muted">- keine -</option>
                <? foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"
                            class="category-depth-<?= $category['depth'] ?>"
                            <? if ($category['id'] == $parent_id) echo 'selected'; ?>>
                        <?= htmlReady($category['name']) ?>
                    </option>
                <? endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="icon-ok"></i>
                Speichern
            </button>
            <a class="btn" href="<?= $controller->url_for('categories', $parent_id) ?>">
                <i class="icon-remove"></i>
                Abbrechen
            </a>
        </div>   
    </fieldset> 
</form>