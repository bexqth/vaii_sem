<?php

namespace App\Models;

use App\Core\Model;

class Review extends Model
{
    protected int $id;
    protected int $book_id;
    protected int $user_id;
    protected ?int $rating = 0;
    protected ?string $review_text = "";
    //private ?string $review_author = "";

    public function getReviewAuthor(): string
    {
        $user = User::getOne($this->user_id);
        return $user->getUsername();
        //return $this->review_author;
    }

    public function setReviewAuthor(string $review_author): void
    {
        $this->review_author = $review_author;
    }
    protected ?string $created_at;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getBookId(): int
    {
        return $this->book_id;
    }

    public function setBookId(int $book_id): void
    {
        $this->book_id = $book_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): void
    {
        $this->rating = $rating;
    }

    public function getReviewText(): ?string
    {
        return $this->review_text;
    }

    public function setReviewText(?string $review_text): void
    {
        $this->review_text = $review_text;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function setCreatedAt(?string $created_at): void
    {
        $this->created_at = $created_at;
    }


}