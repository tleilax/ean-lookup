<?php
class AccountController extends AppController
{
    public function before_filter(&$action, &$args)
    {
        if (!method_exists($this, $action . '_action')) {
            array_unshift($args, $action);
            $action = 'index';
        }
        
        parent::before_filter($action, $args);
    }
    
    public function index_action($username = null)
    {
        $this->checkAuth();
    }
}