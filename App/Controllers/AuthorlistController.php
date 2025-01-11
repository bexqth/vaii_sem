<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Author;

class AuthorlistController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        $authors = Author::getAll();
        return $this->html(["authors" => $authors]);
    }

    public function createNewAuthor() {

    }
}