<?php

namespace App\Models;

use App\Core\Model;

class Activity extends Model
{
    protected int $id;
    protected int $user_id;
    protected string $activity_text;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getActivityText(): string
    {
        return $this->activity_text;
    }

    public function setActivityText(string $activity_text): void
    {
        $this->activity_text = $activity_text;
    }

    public function getAuthor() : string {
        $activity = Activity::getOne($this->id);
        $user = User::getOne($activity->user_id);
        return $user->getUsername();
    }

}