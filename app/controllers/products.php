<?php
class ProductsController extends AppController
{
    public function add_action()
    {
        $title = $_REQUEST['title'];
        $brand = $_REQUEST['brand'];
        $ean   = $_REQUEST['ean'];
        
        echo '<pre>';var_dump($title, $brand, $ean);die;
    }
}
