<?php

namespace App\Models;
use App\Core\Model;
class Book extends \App\Core\Model
{
    protected int $id;
    protected int $isbn;
    protected string $title;
    protected ?string $author;
    protected ?string $publication_date;
    protected ?string $genre;
    protected ?string $cover_url;
    protected ?int $pages;
    protected ?string $description;

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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): void
    {
        $this->author = $author;
    }

    public function getPublicationDate(): ?string
    {
        return $this->publication_date;
    }

    public function setPublicationDate(?string $publication_date): void
    {
        $this->publication_date = $publication_date;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): void
    {
        $this->genre = $genre;
    }

    public function getCoverUrl(): ?string
    {
        return $this->cover_url;
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


}