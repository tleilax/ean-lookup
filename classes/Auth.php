<?php
class Auth
{
    const STATUS_NONE      = 0;
    const STATUS_USER      = 1;
    const STATUS_MODERATOR = 2;
    const STATUS_ADMIN     = 8;
    const STATUS_ROOT      = 9;

    protected static $status_mapping = array(
        1 => 'user',
        2 => 'moderator',
        8 => 'administrator',
        9 => 'root',
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

    public static function getNavigationStatus()
    {
        if (!self::User()) {
            return 'none';
        }
        $status = array();
        foreach (self::$status_mapping as $key => $label) {
            if (self::Get()->testAuth($key)) {
                $status[] = $label;
            }
        }
        return $status;
    }

    protected $data = array('status' => self::STATUS_NONE);

    //
    private function __construct()
    {
        if (isset($_SESSION['auth'])) {
            $this->data = json_decode($_SESSION['auth'], true);
        } else if (isset($_COOKIE['memento'])) {
            $cookie_hash = $_COOKIE['memento'];
            $user = R::findOne('user', 'cookie = ?', array($cookie_hash));
            if ($user->id) {
                $this->setAuth($user->status, array('user_id' => $user->id));
            } else {
                setcookie('memento', null, strtotime('-1 week'), '/');
            }
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