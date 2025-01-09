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
                $_SESSION['user_id'] = $user->getId();
                return true;
            }
        }
        return false;
    }

    /**
     * @throws \Exception
     */
    public function isAdmin(): bool {
        $user = User::getOne($this->getLoggedUserId());
        return $user->getRoleId() === 2;
    }

    /**
     * @throws \Exception
     */
    public function isUser(): bool
    {
        $user = User::getOne($this->getLoggedUserId());
        return $user->getRoleId() === 1;
    }
}