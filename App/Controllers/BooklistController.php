<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Author;
use App\Models\Book;

class BooklistController extends AControllerBase
{

    /**
     * Example of an action (authorization needed)
     * @return \App\Core\Responses\Response|\App\Core\Responses\ViewResponse
     */
    public function index(): Response
    {
        $books = Book::getAll();
        $authors = $this->getAuthorsFromBooks($books);
        return $this->html(['books' => $books, "authors" => $authors]);
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
}