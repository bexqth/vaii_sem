<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Book;
use App\Models\Review;

class BookController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        $chosenBookId = $this->request()->getValue("id");
        $chosenBook = Book::getOne($chosenBookId);
        $chosenBookReviews = Review::getAll('book_id = ?', [$chosenBookId]);

        return $this->html(["chosenBook" => $chosenBook, "chosenBookReviews" => $chosenBookReviews]);
    }
}