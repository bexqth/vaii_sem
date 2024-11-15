<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Book;

class ReviewController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        $chosenBookId = $this->request()->getValue("id");
        $chosenBook = Book::getOne($chosenBookId);
        return $this->html(["chosenBook" => $chosenBook]);
    }
}