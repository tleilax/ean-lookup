<form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
    <label>
        EAN:
        <input required autofocus type="text" name="ean" value="<?= @$_REQUEST['ean'] ?>">
    </label>
    <input type="submit" value="Suchen">
</form>

<? if (isset($_REQUEST['ean'])): ?>

<h1>Ergebnisse (<?= date('d.m.Y H:i', $results['timestamp']) ?>)</h1>
<? if ($results && count($results['items']) > 0): ?>
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
                <a href="image-proxy.php?image=<?= urlencode($image['link']) ?>">
                    <img src="image-proxy.php?image=<?= urlencode($image['thumbnails'][0]['link']) ?>" alt="">
                </a>
            <? else: ?>
                <img src="image-proxy.php?image=<?= urlencode($image['link']) ?>" alt="">
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

<? if (isset($_REQUEST['debug'])): ?>
<pre><? var_dump($results); ?></pre>
<? endif; ?>

<? endif; ?>
