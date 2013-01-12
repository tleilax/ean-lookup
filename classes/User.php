<?php
class User
{
    public static function isLoggedIn()
    {
        return !empty($_SESSION['user_id']);
    }
}