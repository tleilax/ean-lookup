<?php
class AppController extends Trails_Controller
{
    protected $flash;
    
    public function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);

        $this->flash = Trails_Flash::instance();

        $layout = $this->get_template('layout');
        $layout->request_uri = $this->dispatcher->request_uri;
        $layout->messages    = $this->get_messages();
        $this->set_layout($layout);


        $navigation   = Navigation::load('includes/navigation.json');
        $substitutions = array();
        if ($user = Auth::User()) {
            $substitutions['user'] = $user->export();
        }
        $this->navigations = array(
            'primary'   => $navigation->get('default', Auth::getNavigationStatus(), $substitutions),
            'secondary' => $navigation->get('secondary', Auth::getNavigationStatus(), $substitutions),
        );
    }

    public function url_for($to)
    {
        $arguments  = func_get_args();
        $parameters = array();
        if (is_array(end($arguments))) {
            $parameters = array_pop($arguments);
        }
        $to = implode('/', $arguments);
        if (!empty($parameters)) {
            $to .= '?' . http_build_query($parameters);
        }
        return $to;
    }

    public function redirect($to /*, $parameters = array() */)
    {
        $arguments  = func_get_args();
        $parameters = array();
        if (is_array(end($arguments))) {
            $parameters = array_pop($arguments);
        }
        $to = implode('/', $arguments);
        if (!empty($parameters)) {
            $to .= '?' . http_build_query($parameters);
        }
        parent::redirect($to);
    }

    public function checkAuth($status = Auth::STATUS_USER)
    {
        if (!Auth::get()->testAuth($status)) {
            $this->redirect('auth/login?return_to=' . urlencode($this->dispatcher->request_uri));
        }
    }
    
    protected function get_template($template_name)
    {
        static $factory = null;
        if ($factory === null) {
            $directory = $this->dispatcher->trails_root . '/views/';
            $factory   = new Flexi_TemplateFactory($directory);
        }
        return $factory->open($template_name);
    }
    
    protected function get_messages($clear = true)
    {
        $messages = isset($_SESSION['messages'])
                  ? $_SESSION['messages']
                  : array();
        if ($clear) {
            unset($_SESSION['messages']);
        }
        return $messages;
    }
    
    protected function report_message($type, $message)
    {
        $message = vsprintf($message, array_slice(func_get_args(), 2));

        $messages = $this->get_messages(false);
        $messages[] = compact('type', 'message');
        $_SESSION['messages'] = $messages;
    }
    
    public function __call($method, $arguments)
    {
        if (preg_match('/^report_(error|info|success|warning)$/', $method, $match)) {
            $type = $match[1];
            array_unshift($arguments, $type);
            call_user_func_array(array($this, 'report_message'), $arguments);
        } else {
            throw new BadMethodCallException('Unknown method "' . $method . '"');
        }
    }
}