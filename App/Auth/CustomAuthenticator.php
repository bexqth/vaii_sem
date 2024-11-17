<?php

namespace App\Auth;

use App\Auth\DummyAuthenticator;
use App\Models\User;

class CustomAuthenticator extends DummyAuthenticator
{
    public function login($login, $password): bool
    {
        $users = User::getAll('username = ?', [$login]);
        $user = $users[0];

        if($login == $user->getUsername()) {
            if(password_verify($password, $user->getPassword())) {
                //$_SESSION['user'] = self::USERNAME;
                $_SESSION['user'] = $user->getUsername();
                return true;
            }
        }
        return false;

        /*if ($login ==  $user->getUsername() && password_verify($password, self::PASSWORD_HASH)) {
            $_SESSION['user'] = self::USERNAME;
            return true;
        } else {
            return false;
        }*/
    }
}