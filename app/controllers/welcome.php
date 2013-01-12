<?php
class WelcomeController extends Trails_Controller
{
    public function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);
        
        $this->set_layout('layout');
    }
    
    public function index_action()
    {
        
    }
}