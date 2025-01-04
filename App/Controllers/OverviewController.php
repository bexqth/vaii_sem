<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Activity;
use App\Models\Follow;
use App\Models\Profile;
use App\Models\User;

class OverviewController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        $followedUsersActivities = $this->getActivities();
        $followedUsersProfiles = $this->getAuthorsOfActivities($followedUsersActivities);
        return $this->html(["followedPeopleActivities" =>$followedUsersActivities, "followedUsersProfiles" => $followedUsersProfiles]);
    }


    public function getActivities(): array {
        $activities = [];
        $follows = Follow::getAll();

        foreach ($follows as $follow) {
            if ($follow->getFollowerId() == $this->app->getAuth()->getLoggedUserId()) {
                $followedPersonId = $follow->getFollowedId();
                $personActivities = Activity::getAll("user_id = ?", [$followedPersonId]);
                $activities = array_merge($activities, $personActivities); //https://www.w3schools.com/php/func_array_merge.asp
            }
        }

        return $activities;
    }


    public function getAuthorsOfActivities($activities) {
        $profiles = [];
        foreach ($activities as $activity) {
            $profile = Profile::getAll("user_id = ?", [$activity->getUserId()]);
            $profiles[] = $profile[0];
        }
        return $profiles;
    }
}