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

            $this->redirect('auth/registered');
            return;
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
                $this->redirect($this->return_to ?: 'welcome/index');
                return;
            }
        }
    }

    function logout_action()
    {
        Auth::get()->unsetAuth();
        $this->redirect('welcome/index');
    }
}