<?php
class LookupController extends AppController
{
    public function search_action($debug = false)
    {
        $this->checkAuth();

        $this->ean   = @$_REQUEST['ean'] ?: '';
        $this->debug = !empty($debug);

        if (!empty($this->ean)) {
            $this->product = R::findOne('product', 'ean = ?', array($this->ean));
            if ($this->product === null) {
                $product = R::dispense('product');
                $product->ean = $this->ean;
                $id = R::store($product);

                $this->product = $product;

                $this->results = Cache::find($this->ean, 'json', function ($needle) {
                    $results = Lookup::Google($needle);
                    $results['timestamp'] = time();

                    return $results;
                });
            }
        } else {
            $this->product = false;
            $this->results = false;
        }
    }
}
