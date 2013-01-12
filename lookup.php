<?php
    require_once 'bootstrap.php';

    $results = false;
    if (!empty($_REQUEST['ean'])) {
        $product = Product::find($_REQUEST['ean']);
        if ($product->isNew()) {
            $results = Cache::find($_REQUEST['ean'], 'json', function ($needle) {
                $results = Lookup::Google($needle);
                $results['timestamp'] = time();

                return $results;
            });
        }
    }

    echo render('lookup', compact('results'), 'layout');
