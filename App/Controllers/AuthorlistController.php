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

    public function editAuthor() {
        $data = $this->request()->getRawBodyJSON();
        $authorName = $data->authorName;
        $authorId = $data->authorId;
        $author = null;

        if($authorId == null) { //creating
            $author = new Author();
            $message = "New author added";
        } else { //editing
            $author = Author::getOne($authorId);
            $message = "Author updated";
        }
        $author->setName($authorName);
        $author->save();
        $updatedAuthors = $this->getUpdatedAuthors();
        return $this->json($updatedAuthors);
    }

    public function getUpdatedAuthors() {
        $authors = Author::getAll();
        $allAuthors = [];
        for ($i = 0; $i < count($authors); $i++) {
            $author = $authors[$i];
            $allAuthors[] = [
                'id' => $author->getId(),
                'name' => $author->getName()
            ];
        }
        return $allAuthors;
    }
}