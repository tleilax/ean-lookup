<?php
class AuthController extends AppController
{
    function register_action()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = R::dispense('user');
            $user->nickname = $_POST['nickname'];
            $user->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $user->email    = $_POST['email'];
            $user->status   = Auth::STATUS_USER;
            $user->register_timestamp = R::isoDateTime();
            $user->last_action        = null;
            $id = R::store($user);

            $this->report_succes('Sie haben sich erfolgreich registriert');
            $this->redirect('auth/registered');
        }
    }
    
    function registered_action()
    {
    }

    function login_action()
    {
        $this->return_to = @$_REQUEST['return_to'] ?: '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = R::findOne('user', '? IN (nickname, email)', array($_POST['nickname']));

            if ($user->password && password_verify($_POST['password'], $user->password)) {
                if (password_needs_rehash($user->password, PASSWORD_BCRYPT)) {
                    $user->password = password_hash($_POST['password']);
                    R::store($user);
                }

                Auth::get()->setAuth($user->status, array('user_id' => $user->id));

                if ($_REQUEST['remember-me']) {
                    $cookie_hash  = md5(uniqid('cookie-hash', true));
                    $user->cookie = $cookie_hash;
                    R::store($user);

                    setcookie('memento', $cookie_hash, strtotime('+1 month'), '/');
                }

                $this->redirect($this->return_to ?: 'welcome/index');
                return;
            }
        }
    }

    function logout_action()
    {
        Auth::get()->unsetAuth();
        if ($_COOKIE['memento']) {
            setcookie('memento', null, strtotime('-1 week'), '/');
        }
        $this->redirect('welcome/index');
    }
}