<form action="<?= $controller->url_for('lookup/search') ?>" method="get">
    <label>
        EAN:
        <input required autofocus type="text" name="ean" value="<?= @$ean ?>">
    </label>
    <input type="submit" value="Suchen">
</form>

<? if (!empty($ean)): ?>

<? if ($results && !empty($results['items'])): ?>
<h1>Ergebnisse (<?= date('d.m.Y H:i', $results['timestamp']) ?>)</h1>
<ul class="products">
<? foreach ($results['items'] as $result): ?>
    <li class="product">
        <h2 class="product-title"><?= $result['product']['title'] ?></h2>
    <? if (!empty($result['product']['description'])): ?>
        <p class="product-description"><?= nl2br($result['product']['description']) ?></p>
    <? endif; ?>
    <? if (count($result['product']['images']) > 0): ?>
        <ul class="product-images">
        <? foreach ($result['product']['images'] as $image): ?>
            <li class="product-image">
            <? if ($image['thumbnails']): ?>
                <a href="external-image/<?= $image['link'] ?>">
                    <img src="external-image/<?= $image['thumbnails'][0]['link'] ?>" alt="ff">
                </a>
            <? else: ?>
                <img src="image-proxy.php?image=<?= $image['link'] ?>" alt="">
            <? endif; ?>
            </li>
        <? endforeach; ?>
        </ul>
    <? endif; ?>
    </li>
<? endforeach; ?>
</ul>
<? else: ?>
<p><?= _('Keine Ergebnisse') ?></p>
<? endif; ?>

<? if ($debug): ?>
<pre><? var_dump($results); ?></pre>
<? endif; ?>

<? endif; ?>
