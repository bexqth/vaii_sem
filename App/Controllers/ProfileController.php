<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\User;

class ProfileController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        $users = User::getAll('username = ?', [$this->app->getAuth()->getLoggedUserName()]);
        $user = $users[0];
        $user = User::getOne($user->getId());
        return $this->html(['user' => $user]);
    }
}