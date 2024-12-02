<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Book;
use App\Models\Review;
use App\Models\Readinglist;
use App\Models\User;

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
        $readingLists = Readinglist::getAll('book_id = ?', [$chosenBookId]);
        if ($readingLists == null) {
            $bookStatus = null;
        } else {
            $readingList = $readingLists[0];
            $bookStatus = $readingList->getStatus();
        }


        return $this->html(["chosenBook" => $chosenBook, "chosenBookReviews" => $chosenBookReviews, "bookStatus" => $bookStatus]);
    }

    /**
     * @throws \JsonException
     * @throws \Exception
     */
    public function setBookStatus() {
        $data = $this->request()->getRawBodyJSON();
        $bookId = $data->bookId;
        $listName = $data->list;

        $book = Book::getOne($bookId);
        //$userIds = User::getAll('username = ?', [$this->app->getAuth()->getLoggedUserName()]);
        $inList = Readinglist::getAll('book_id = ?', [$bookId]);
        if(count($inList) == 0) {
            $readingList = new Readinglist();
            $readingList->setBookId($bookId);

            $userIds = User::getAll('username = ?', [$this->app->getAuth()->getLoggedUserName()]);
            $userId = $userIds[0];

            $readingList->setUserId($userId->getId());
            $readingList->setStatus($listName);

            $readingList->save();
        } else {
            $readingList = $inList[0];
            if($readingList->getStatus() != $listName) {
                $readingList->delete();

                $newList = new Readinglist();
                $newList->setBookId($bookId);

                $userIds = User::getAll('username = ?', [$this->app->getAuth()->getLoggedUserName()]);
                $userId = $userIds[0];

                $newList->setUserId($userId->getId());
                $newList->setStatus($listName);

                $newList->save();
            }

        }
    }
}