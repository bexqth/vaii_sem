<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
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
        if (is_object($data) && property_exists($data, 'authorId') &&  property_exists($data, 'authorName')) {
            $authorName = $data->authorName;
            $authorId = $data->authorId;
            $author = null;

            $numbers = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"];
            for ($i = 0; $i < strlen($authorName); $i++) {
                for ($j = 0; $j < count($numbers); $j++) {
                    if($authorName[$i] == $numbers[$j]) {
                        $message = 'Author name cant contain numbers';
                        $type = "error";
                        return $this->json(["message" => $message, "type" => $type]);
                    }
                }
            }

            if($authorId == null) { //creating
                $author = new Author();
                $message = "New author added";
                $type = "success";
            } else { //editing
                $author = Author::getOne($authorId);
                $message = "Author updated";
                $type = "success";
            }
            $author->setName($authorName);
            $author->save();
            $updatedAuthors = $this->getUpdatedAuthors();
            return $this->json(["message" => $message, "type" => $type, "updatedAuthors" => $updatedAuthors]);
            //return $this->json($updatedAuthors);
        } else {
            throw new HTTPException(400, 'Bad message structure');
        }

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