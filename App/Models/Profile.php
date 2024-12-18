<?php

namespace App\Models;

use App\Core\Model;

class Profile extends Model
{

    protected int $id;
    protected int $user_id;
    protected ?string $bio;
    protected ?string $profile_picture;
    protected ?string $banner_picture;

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

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): void
    {
        $this->bio = $bio;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profile_picture;
    }

    public function setProfilePicture(?string $profile_picture): void
    {
        $this->profile_picture = $profile_picture;
    }

    public function getBannerPicture(): ?string
    {
        return $this->banner_picture;
    }

    public function setBannerPicture(?string $banner_picture): void
    {
        $this->banner_picture = $banner_picture;
    }

}