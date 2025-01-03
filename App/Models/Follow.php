<?php

namespace App\Models;

use App\Core\Model;

class Follow extends Model
{
    protected int $id;
    protected int $follower_id; //THE ONE FOLLOWING
    protected int $followed_id; //THE ONE BEING FOLLOWED

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFollowerId(): int
    {
        return $this->follower_id;
    }

    public function setFollowerId(int $follower_id): void
    {
        $this->follower_id = $follower_id;
    }

    public function getFollowedId(): int
    {
        return $this->followed_id;
    }

    public function setFollowedId(int $followed_id): void
    {
        $this->followed_id = $followed_id;
    }



}