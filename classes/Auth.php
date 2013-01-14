<?php
class Auth
{
    const STATUS_NONE = 0;
    const STATUS_USER = 1;
    const STATUS_ROOT = 2;

    protected static $status_mapping = array(
        1 => 'user',
        2 => 'root',
    );

    protected static $instance = null;

    //
    public static function Get()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    public static function User()
    {
        static $user = false;

//        echo '<pre>';var_dump(self::Get()->testAuth(self::STATUS_USER, $data), $_SESSION, $data);die;

        $data = null;
        if (!self::Get()->testAuth(self::STATUS_USER, $data)) {
            return false;
        }

        if ($user === false) {
            $user = R::load('user', $data['user_id']);
            $user->last_action = R::isoDateTime();
            R::store($user);
        }

        return $user;
    }

    protected $data = array('status' => self::STATUS_NONE);

    //
    private function __construct()
    {
        if (isset($_SESSION['auth'])) {
            $this->data = json_decode($_SESSION['auth'], true);
        }
    }

    public function setAuth($status, $additional = null)
    {
        $this->data['status'] = $status;
        if (func_num_args() > 1) {
            $this->data['additional'] = $additional;
        } else {
            unset($this->data['additional']);
        }
        $_SESSION['auth'] = json_encode($this->data);
    }

    public function testAuth($status = self::STATUS_USER, &$additional = null)
    {
        $additional = @$this->data['additional'] ?: null;
        return $status <= $this->data['status'];
    }

    public function unsetAuth()
    {
        $this->data['status'] = self::STATUS_NONE;
        unset($_SESSION['auth']);
    }
}