<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\User;

class UserlistController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        $users = User::getAll();
        return $this->html(["users" => $users]);
    }
}