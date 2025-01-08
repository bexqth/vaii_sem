<?php

namespace App\Models;

use App\Core\Model;

class FavoriteBook extends Model
{

    protected int $id;
    protected int $user_id;
    protected int $book_id;

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

    public function getBookId(): int
    {
        return $this->book_id;
    }

    public function setBookId(int $book_id): void
    {
        $this->book_id = $book_id;
    }


}