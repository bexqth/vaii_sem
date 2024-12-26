<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Profile;
use App\Models\Review;
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

    public function useroverview(): Response {
        $id = $this->request()->getValue("id");
        $user = User::getOne($id);
        $userProfiles = Profile::getAll("user_id = ?", [$id]);
        $userProfile = $userProfiles[0];
        $reviews = Review::getAll("user_id = ?", [$id]);
        return $this->html(["user" => $user, "userProfile" => $userProfile, "reviews" => $reviews]);
    }
}