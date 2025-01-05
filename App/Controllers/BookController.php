<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\EmptyResponse;
use App\Core\Responses\Response;
use App\Models\Activity;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Profile;
use App\Models\Readingprogress;
use App\Models\Review;
use App\Models\Readinglist;
use App\Models\User;
use HttpException;

class BookController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        //REFACOTR
        $chosenBookId = $this->request()->getValue("id");
        $chosenBook = Book::getOne($chosenBookId);
        $chosenBookReviews = Review::getAll('book_id = ?', [$chosenBookId]);
        $reviewUsers = [];
        if($chosenBookReviews != null) {
            $reviewUsers = $this->getReviewUsers($chosenBookReviews);
        }

        $userId = $this->app->getAuth()->getLoggedUserId();
        $readingLists = Readinglist::getAll('book_id = ? AND user_id = ?', [$chosenBookId, $userId]);

        if($this->app->getAuth()->isLogged() && !$this->app->getAuth()->isAdmin()) { // DO THIS CONDITION WITHOUT IT, IT WILL CRASH
            $readingProgresses = Readingprogress::getAll('book_id = ? AND user_id = ?', [$chosenBookId, $userId]);
        } else {
            $readingProgresses = null;
        }

        if($readingProgresses == null) {
            $progressPercentage = 0;
            $readingProgress = null;
        } else {
            $readingProgress = $readingProgresses[0];
            $progressPercentage = ($readingProgress->getPagesRead() / $chosenBook->getPages()) * 100;
        }

        if ($readingLists == null) {
            $bookStatus = null;
        } else {
            $readingList = $readingLists[0];
            $bookStatus = $readingList->getStatus();
        }

        $bookAuthor = Author::getOne($chosenBook->getAuthorId());
        $bookGenre = Genre::getOne($chosenBook->getGenreId());

        return $this->html(["chosenBook" => $chosenBook, "chosenBookReviews" => $chosenBookReviews, "bookStatus" => $bookStatus, "readingProgress" => $readingProgress, "progressPercentage" => $progressPercentage,
            "bookAuthor" => $bookAuthor, "bookGenre" => $bookGenre, "reviewUsers" => $reviewUsers]);
    }

    public function getReviewUsers($reviews) : array {
        $users = [];
        foreach ($reviews as $review) {
            $u = Profile::getAll("user_id = ?", [$review->getUserId()]);
            $users[] = $u[0];
        }
        return $users;
    }

    /**
     * @throws \JsonException
     * @throws \Exception
     */
    public function setBookStatus() : Response {
        $data = $this->request()->getRawBodyJSON();

        if (is_object($data) && property_exists($data, 'bookId') &&  property_exists($data, 'list')) {
            $bookId = $data->bookId;
            $bookName = Book::getOne($bookId)->getTitle();
            $listName = $data->list;
            $userId = $this->app->getAuth()->getLoggedUserId();
            $book = Book::getOne($bookId);
            //$userIds = User::getAll('username = ?', [$this->app->getAuth()->getLoggedUserName()]);
            $inList = Readinglist::getAll('book_id = ? AND user_id = ?', [$bookId, $userId]);
            if(count($inList) == 0) {
                $readingList = new Readinglist();
                $readingList->setBookId($bookId);

                $userIds = User::getAll('username = ?', [$this->app->getAuth()->getLoggedUserName()]);
                $userId = $userIds[0];

                $readingList->setUserId($userId->getId());
                $readingList->setStatus($listName);

                $readingList->save();
                $this->addActivityReadingList($listName, $bookName);

                $message = 'Book added to reading list successfully';
                return $this->json(['message' => $message]);
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
                    $this->addActivityReadingList($listName, $bookName);

                    $message = 'Book status updated successfully';
                    return $this->json(['message' => $message]);
                }

            }
            $message = 'Book already in the specified list';
            return $this->json(['message' => $message]);
        }
        throw new HTTPException(400, 'Invalid request data');
    }

    public function addActivityReadingList($readingList, $bookName): void {
        $newActivity = new Activity();
        $newActivity->setUserId($this->app->getAuth()->getLoggedUserId());
        switch ($readingList) {
            case "reading":
                $newActivity->setActivityText("Started reading {$bookName}");
                break;
            case "planning":
                $newActivity->setActivityText("Plans to read {$bookName}");
                break;
            case "finished":
                $newActivity->setActivityText("Finished reading {$bookName}");
                break;
        }
        $newActivity->save();
    }


    public function form() {
        $chosenBookId = $this->request()->getValue("id");
        if($chosenBookId !== null) {
            $chosenBook = Book::getOne($chosenBookId);
            $bookAuthor = Author::getOne($chosenBook->getAuthorId());
            $bookGenre = Genre::getOne($chosenBook->getGenreId());

            $bookAuthors = Author::getAll("name != ?", [$bookAuthor->getName()]);
            $bookGenres = Genre::getAll("name != ?", [$bookGenre->getName()]);

            return $this->html(["chosenBook" => $chosenBook, "bookAuthor" => $bookAuthor, "bookGenre" => $bookGenre, "bookAuthors" => $bookAuthors, "bookGenres" => $bookGenres]);
        } else {
            $bookAuthors = Author::getAll();
            $bookGenres = Genre::getAll();
            $chosenBook = null;
            return $this->html(["chosenBook" => $chosenBook, "bookAuthors" => $bookAuthors, "bookGenres" => $bookGenres]);
        }


    }


    /**
     * @throws \Exception
     */
    public function submitBook() {
        $data = $this->app->getRequest()->getFiles();
        //$bookCover =  $this->app->getRequest()->getFiles()["bookCover"];
        $title = $this->app->getRequest()->getValue("title");
        $author = $this->app->getRequest()->getValue("author");
        $genre = $this->app->getRequest()->getValue("genre");
        $isbn = $this->app->getRequest()->getValue("isbn");
        $pages = $this->app->getRequest()->getValue("pages");
        $year = $this->app->getRequest()->getValue("year");

        $bookCoverContent = null;
        $modifiedBook = null;

        if (isset($data["bookCover"])) {
            $bookCover = $data["bookCover"]['tmp_name'];
            $bookCoverContent = file_get_contents($bookCover);
        }

        $books = Book::getAll("isbn = ?", [$isbn]);
        if($books == null) {
            $modifiedBook = new Book();
        } else {
            $modifiedBook = $books[0];
        }

        $modifiedBook->setTitle($title);
        $modifiedBook->setPages($pages);
        $modifiedBook->setIsbn($isbn);
        $modifiedBook->setPublicationDate($year);

        $authorIds = Author::getAll("name = ?", [$author]);
        $modifiedBook->setAuthorId($authorIds[0]->getId());

        $genreIds = Genre::getAll("name = ?", [$genre]);
        $modifiedBook->setGenreId($genreIds[0]->getId());

        if ($bookCoverContent !== null) {
            $modifiedBook->setCoverUrl($bookCoverContent);
        }
        $modifiedBook->save();
    }

    /**
     * @throws \Exception
     */
    public function delete() {
        $bookId = $this->request()->getValue("id");
        $book = Book::getOne($bookId);
        $book->delete();
        return $this->redirect($this->url("booklist.index"));
    }



}