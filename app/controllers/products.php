<?php
class ProductsController extends AppController
{
    public function categories_action()
    {
        $this->checkAuth();
    }
}