<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Genre;

class GenrelistController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        $genres = Genre::all();
        return $this->html(["genres" => $genres]);
    }

    public function createNewGenre() {

    }
}