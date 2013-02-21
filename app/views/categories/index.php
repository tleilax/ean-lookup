<? if (Auth::Get()->testAuth(Auth::STATUS_ROOT)): ?>
<div>
    <div class="btn-toolbar">
        <div class="btn-group">
            <a class="btn btn-small btn-success" href="<?= $controller->url_for('categories/new', isset($category) ? $category->id : null) ?>">
                <i class="icon-plus icon-white"></i>
                Neue Unterkategorie
            </a>
        </div>
        <? if (isset($category)): ?>
        <div class="btn-group pull-right">
            <a class="btn btn-small" href="<?= $controller->url_for('categories/edit', $category->id) ?>">
                <i class="icon-edit"></i>
                Bearbeiten
            </a>
            <a class="btn btn-small btn-danger" href="<?= $controller->url_for('categories/delete', $category->id) ?>">
                <i class="icon-trash icon-white"></i>
                Löschen
            </a>
        </div>
        <? endif; ?>
    </div>
</div>
<? endif; ?>

<?
    $path = array(
        array(
            'id'   => '',
            'name' => 'Kategorien',
        ),
    );
    if (isset($category)) {
        foreach ($category->getPath() as $item) {
            $path[] = $item->export();
        }
    }
?>
<ul class="breadcrumb">
<? foreach ($path as $index => $crumb): ?>
<? if ($index == count($path) - 1): ?>
    <li class="active">
        <?= htmlReady($crumb['name']) ?>
    </li>
<? else: ?>
    <li>
        <a href="<?= $controller->url_for('categories', $crumb['id']) ?>">
            <?= htmlReady($crumb['name']) ?>
        </a>
        <span class="divider">&bull;</span>
    </li>
<? endif; ?>
<? endforeach; ?>
</ul>

<? if (isset($category) && $category->description): ?>
<p class="lead">
    <?= htmlReady($category->description) ?>
</p>
<? endif; ?>

<? if (!empty($children)): ?>
<ul>
<? foreach ($children as $category): ?>
    <li>
        <a href="<?= $controller->url_for('categories', $category['id']) ?>">
            <?= htmlReady($category['name']) ?>
        </a>
    </li>
<? endforeach; ?>
</ul>
<? endif; ?>
