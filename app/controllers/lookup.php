<?php
class LookupController extends Trails_Controller
{
    public function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);
        
        $this->set_layout('layout');
    }
    
    public function search_action($debug = false)
    {
        $this->ean   = @$_REQUEST['ean'] ?: '';
        $this->debug = !empty($debug);

        if (!empty($this->ean)) {
            $this->product = Product::find($this->ean);
            if ($this->product->isNew()) {
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
