<?php
class AppController extends Trails_Controller
{
    public function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);

        $this->set_layout('layout');
    }

    public function checkAuth($status = Auth::STATUS_USER)
    {
        if (!Auth::get()->testAuth($status)) {
            $this->redirect('auth/login?return_to=' . urlencode($this->dispatcher->request_uri));
        }
    }
}