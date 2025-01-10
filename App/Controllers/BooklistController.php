<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;

class BooklistController extends AControllerBase
{


    public function authorize($action)
    {
        return true;
    }

    public function index(): Response
    {
        $books = Book::getAll();
        $genres = Genre::getAll();
        $authors = Author::getAll();
        $authors = $this->getAuthorsFromBooks($books);
        return $this->html(['books' => $books, "authors" => $authors, "genres" => $genres, "allAuthors" => $authors]);
    }

    public function getAuthorsFromBooks($books): array
    {
        $authors = [];
        foreach ($books as $book) {
            $author = Author::getOne($book->getAuthorId());
            $authors[] = $author;
        }
        return $authors;

    }

    public function filterByGenre() {
        $data = $this->request()->getRawBodyJSON();
        $genre = Genre::getOne($data->genreId);
        $filteredBooks = Book::getAll("genre_id = ?", [$genre->getId()]);
        $filteredBooksArray = [];
        foreach ($filteredBooks as $book) {
            $author = Author::getOne($book->getAuthorId());
            $filteredBooksArray[] = [
                'title' => $book->getTitle(),
                'author' => $author->getName(),
                'cover_url' => $book->getCoverUrl(),
            ];
        }
        return $this->json($filteredBooksArray);
    }
}