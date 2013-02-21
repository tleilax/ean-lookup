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
                // $product->ean = $this->ean;
                // $id = R::store($product);

                $this->product = $product;

                $this->results = Cache::find($this->ean, 'json', function ($needle) {
                    $results = Lookup::Google($needle);
                    $results['timestamp'] = time();

                    return $results;
                });

                if (isset($this->results['items'])) {
                    $titles = array();
                    $brands = array();
                    $images = array();
                    foreach ($this->results['items'] as $result) {
                        $titles[] = $result['product']['title'];
                        if (isset($result['product']['brand'])) {
                            $brands[] = $result['product']['brand'];
                        }
                        foreach ($result['product']['images'] as $image) {
                            $thumbnail = null;
                            if (!empty($image['thumbnails'])) {
                                $temp      = reset($image['thumbnails']);
                                $thumbnail = $temp['link'];
                            }
                            $images[] = array(
                                'link'      => $image['link'],
                                'thumbnail' => $thumbnail,
                            );
                        }
                    }

                    $this->tree   = Oracle::parseTree($titles);
                    $this->title  = Oracle::guess($titles);
                    $this->brand  = Oracle::guess($brands);
                    $this->images = $images;
                }
            }
        } else {
            $this->product = false;
            $this->results = false;
        }
    }
}
