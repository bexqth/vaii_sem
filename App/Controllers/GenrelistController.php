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
        $genres = Genre::getAll();
        return $this->html(["genres" => $genres]);
    }

    /**
     * @throws \JsonException
     */
    public function editGenre() {
        $data = $this->request()->getRawBodyJSON();
        $genreName = $data->genreName;
        $genreId = $data->genreId;
        $genre = null;

        if($genreId == null) { //creating
            $genre = new Genre();
        } else { //editing
            $genre = Genre::getOne($genreId);
        }
        $genre->setName($genreName);
        $genre->save();
        $updatedGenres = $this->getUpdatedGenres();
        return $this->json($updatedGenres);
    }

    public function getUpdatedGenres() {
        $genres = Genre::getAll();
        $allGenres = [];
        for ($i = 0; $i < count($genres); $i++) {
            $genre = $genres[$i];
            $allGenres[] = [
                'id' => $genre->getId(),
                'name' => $genre->getName()
            ];
        }
        return $allGenres;
    }
}