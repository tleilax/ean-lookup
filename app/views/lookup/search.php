<? function listNode($node) { ?>
<? foreach ($node as $token => $data): ?>
<li>
    <?= htmlReady($token) ?> [<?= $data['count'] ?>x]
    <ul>
        <?= listNode($data['children']) ?>
    </ul>
</li>
<? endforeach; ?>
<? } ?>

<? if (isset($_REQUEST['debug'])): ?>
<pre><? var_dump($results); ?></pre>
<? endif; ?>

<form action="<?= $controller->url_for('lookup/search') ?>" method="get" class="form-search">
    <input required autofocus type="text" name="ean" value="<?= @$ean ?>" placeholder="EAN" class="input-medium search-query">
    <button type="submit" class="btn">Suchen</button>
</form>

<? if (isset($title)): ?>
<form action="<?= $controller->url_for('products/add') ?>" action="post" class="form-horizontal">
    <input type="hidden" name="ean" value="<?= $ean ?>">

    <fieldset>
        <legend>Produkt hinzufügen</legend>
        
        <div class="control-group">
            <label class="control-label" for="title">Titel</label>
            <div class="controls">
                <input class="input-xxlarge" type="text" name="title" id="title" value="<?= htmlReady($title) ?>">
            <? if (isset($tree)): ?>
                <span class="help-block">
                    <button type="button" class="btn btn-inverse" data-toggle="collapse" data-target="#title-tree">
                        Baum anzeigen
                    </button>
                    <div id="title-tree" class="collapse out">
                        <div class="well">
                            <ul>
                                <?= listNode($tree) ?>
                            </ul>
                        </div>
                    </div>
                </span>
            <? endif; ?>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="brand">Hersteller</label>
            <div class="controls">
                <input class="input-xxlarge" type="text" name="brand" id="brand" value="<?= htmlReady($brand) ?>">
            </div>
        </div>
        
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn btn-success">Hinzufügen</button>
            </div>
        </div>
    </fieldset>
</form>

    <div class="row">
        <ul class="thumbnails">
        <? foreach ($images as $image): ?>
            <li class="span3">
                <div class="thumbnail">
                    <div class="close-trigger">
                        <i class="icon-remove"></i>
                    </div>
                    <img src="external-image/<?= $image['thumbnail'] ?>" alt="">
                    <h3><small>Größe: <span class="dimensions">lädt</span></small></h3>
                    <div class="btn-group">
                        <a href="external-image/<?= $image['link'] ?>" class="btn modal-image original-image"
                           data-target="#image-modal">
                            <i class="icon-picture"></i>
                            Anzeigen
                        </a>
                        <a href="#" class="btn">
                            <i class="icon-bookmark"></i>
                            Cover
                        </a>
                        <a href="#" class="btn">
                            <i class="icon-film"></i>
                            Extra
                        </a>
                    </div>
                </div>
            </li>
        <? endforeach; ?>
        </ul>

        <div id="image-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-body" style="text-align: center;">
                <div class="dimensions"></div>
                <img src="" alt="">
            </div>
        </div>

    </div>
<? endif; ?>

<? if (!empty($ean)): ?>

<? if ($results && !empty($results['items'])): ?>
<table class="table table-striped table-condensed">
    <caption>
        <h3>
            Ergebnisse (<?= date('d.m.Y H:i', $results['timestamp']) ?>)
        </h3>
    </caption>
    <tbody>
    <? foreach ($results['items'] as $result): ?>
        <tr>
            <td>
                <h4><?= htmlReady($result['product']['title']) ?></h4>
            <? if (!empty($result['product']['description'])): ?>
                <p><?= htmlReady($result['product']['description']) ?></p>
            <? endif; ?>
            </td>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>
<? else: ?>
<p><?= _('Keine Ergebnisse') ?></p>
<? endif; ?>

<? endif; ?>
