<?php

namespace App\Models;
use App\Core\Model;
class Book extends Model
{
    protected int $id;
    protected int $isbn;
    protected string $title;
    protected ?string $publication_date;
    protected ?string $cover_url;
    protected ?int $pages;
    protected ?string $description;
    protected ?int $author_id;
    protected ?int $genre_id;

    public function getAuthorId(): ?int
    {
        return $this->author_id;
    }

    public function setAuthorId(?int $author_id): void
    {
        $this->author_id = $author_id;
    }

    public function getGenreId(): ?int
    {
        return $this->genre_id;
    }

    public function setGenreId(?int $genre_id): void
    {
        $this->genre_id = $genre_id;
    }


    public function getIsbn(): int
    {
        return $this->isbn;
    }

    public function setIsbn(int $isbn): void
    {
        $this->isbn = $isbn;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getPublicationDate(): ?string
    {
        return $this->publication_date;
    }

    public function setPublicationDate(?string $publication_date): void
    {
        $this->publication_date = $publication_date;
    }

    public function getCoverUrl(): ?string
    {
        if ($this->cover_url) {
            return 'data:image/jpeg;base64,' . base64_encode($this->cover_url);
        }
        return null;
    }

    public function setCoverUrl(?string $cover_url): void
    {
        $this->cover_url = $cover_url;
    }

    public function getPages(): ?int
    {
        return $this->pages;
    }

    public function setPages(?int $pages): void
    {
        $this->pages = $pages;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAverageRating() : float {
        $count = 0;
        $possible = 0;
        $reviews = Review::getAll("book_id = ?", [$this->id]);
        if(count($reviews) > 0) {
            foreach ($reviews as $review) {
                $count += 1;
                $possible += $review->getRating();

            }
        } else {
            return 0;
        }

        return $possible / $count;
    }

}