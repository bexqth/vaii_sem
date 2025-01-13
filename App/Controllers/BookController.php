<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\EmptyResponse;
use App\Core\Responses\Response;
use App\Models\Activity;
use App\Models\Author;
use App\Models\Book;
use App\Models\FavoriteBook;
use App\Models\Follow;
use App\Models\Genre;
use App\Models\Profile;
use App\Models\Readingprogress;
use App\Models\Review;
use App\Models\Readinglist;
use App\Models\User;
use DateTime;
use HttpException;

class BookController extends AControllerBase
{

    public function authorize(string $action)
    {
        switch ($action) {
            case "addAsFavoriteBook":
            case "removeAsFavoriteBook":
            case "setBookStatus":
            case "editReadingProgress":
                return $this->app->getAuth()->isLogged() && $this->app->getAuth()->isUser();
            case "index":
                return $this->app->getAuth()->isLogged();
            default:
                return true;
        }
    }


    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        //REFACOTR
        $chosenBookId = $this->request()->getValue("id");
        $chosenBook = Book::getOne($chosenBookId);
        $chosenBookReviews = Review::getAll('book_id = ?', [$chosenBookId]);
        $chosenBookReviews  = array_reverse($chosenBookReviews);
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
        $followings = $this->getFollowing($chosenBookId);

        $followingsUsers = array_column($followings, 'user_name');
        $followingsStatuses = array_column($followings, 'status');
        $followingsProfilePics = array_column($followings, 'profile_pic');

        $distributions = $this->getStatusDistribution($chosenBookId);
        $readingCount = array_column($distributions, 'readingCount');
        $planningCount = array_column($distributions, 'planningCount');
        $finishedCount = array_column($distributions, 'finishedCount');

        $favoriteBooks = FavoriteBook::getAll("user_id = ? AND book_id = ?", [$userId, $chosenBookId]);
        if(count($favoriteBooks) == 0) {
            $isFavorite = false;
        } else {
            $isFavorite = true;
        }

        return $this->html(["chosenBook" => $chosenBook, "chosenBookReviews" => $chosenBookReviews, "bookStatus" => $bookStatus, "readingProgress" => $readingProgress, "progressPercentage" => $progressPercentage,
            "bookAuthor" => $bookAuthor, "bookGenre" => $bookGenre, "reviewUsers" => $reviewUsers, "followingUsers" => $followingsUsers, "followingsStatuses" => $followingsStatuses, "followingsProfilePics" => $followingsProfilePics,
            "planningCount" => $planningCount[0], "finishedCount" => $finishedCount[0], "readingCount" => $readingCount[0], "isFavorite" => $isFavorite,]);
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
            $inList = Readinglist::getAll('book_id = ? AND user_id = ?', [$bookId, $userId]);
            if(count($inList) == 0) {
                $readingList = new Readinglist();
                $readingList->setBookId($bookId);

                $readingList->setUserId($userId);
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

                    $newList->setUserId($userId);
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
        $id = $this->app->getRequest()->getValue("id");
        $author = $this->app->getRequest()->getValue("author");
        $description = $this->app->getRequest()->getValue("description");
        $genre = $this->app->getRequest()->getValue("genre");
        $isbn = $this->app->getRequest()->getValue("isbn");
        $pages = $this->app->getRequest()->getValue("pages");
        $year = $this->app->getRequest()->getValue("year");


        $numbers = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"];
        for ($i = 0; $i < strlen($title); $i++) {
            for ($j = 0; $j < count($numbers); $j++) {
                if($title[$i] == $numbers[$j]) {
                    $message = 'Title cant contain numbers';
                    $type = "error";
                    return $this->json(["message" => $message, "type" => $type]);
                }
            }
        }

        if($title == null || $author == null || $description == null || $genre == null || $isbn == null|| $pages == null || $year == null) {
            $message = 'Please fill all fields';
            $type = "error";
            return $this->json(["message" => $message, "type" => $type]);
        }

        if (strlen($description) > 400) {
            $message = "Description cannot exceed 400 characters.";
            $type = "error";
            return $this->json(['message' => $message, 'type' => $type]);
        }

        if(!is_numeric($isbn) || !is_numeric($pages) || !is_numeric($year)) {
            $message = 'ISBN, pages and year cant contain letters';
            $type = "error";
            return $this->json(["message" => $message, "type" => $type]);
        }

        $bookCoverContent = null;
        $modifiedBook = null;

        if (isset($data["bookCover"])) {
            $bookCover = $data["bookCover"]['tmp_name'];
            $bookCoverContent = file_get_contents($bookCover);
        } else {
            $message = 'Please provide a book cover';
            $type = "error";
            return $this->json(["message" => $message, "type" => $type]);
        }

        if($id == 0) { //new book
            $bookTemp = Book::getAll("isbn = ?", [(int)$isbn]);
            if(count($bookTemp) != 0) {
                $message = 'Book with chosen ISBN already exists';
                $type = "error";
                return $this->json(["message" => $message, "type" => $type]);
            } else {
                $modifiedBook = new Book();
                $message = 'Book added successfully';
            }

        } else { //editing
            $modifiedBook = Book::getOne($id);
            $message = 'Book updated successfully';
        }

        $modifiedBook->setTitle($title);
        $modifiedBook->setPages($pages);
        $modifiedBook->setDescription($description);
        $modifiedBook->setIsbn($isbn);
        $modifiedBook->setPublicationDate($year);
        $modifiedBook->setCreatedAt(date("Y-m-d"));

        $authorIds = Author::getAll("name = ?", [$author]);
        $modifiedBook->setAuthorId($authorIds[0]->getId());

        $genreIds = Genre::getAll("name = ?", [$genre]);
        $modifiedBook->setGenreId($genreIds[0]->getId());

        if ($bookCoverContent !== null) {
            $modifiedBook->setCoverUrl($bookCoverContent);
        }
        $modifiedBook->save();
        $type = "success";
        return $this->json(["message" => $message, "type" => $type]);
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

    public function editReadingProgress() {
        $data = $this->request()->getRawBodyJSON();

        if (is_object($data) && property_exists($data, 'bookId') && property_exists($data, "pages")) {
            $bookId = $data->bookId;
            $pages = $data->pages;

            $users = User::getAll('username = ?', [$this->app->getAuth()->getLoggedUserName()]);
            $userIds = $users[0];
            $userId = $userIds->getId();

            $readingProgresses = Readingprogress::getAll("user_id = ? AND book_id = ?", [$userId, $bookId]);
            $book = Book::getOne($bookId);
            if($pages > $book->getPages()) {
                $message = 'Selected number of pages is higher than maximum';
                return $this->json(['message' => $message]);
            } else {
                $theReadingProgress = null;
                $pagesDiff = 0;
                if($readingProgresses == null) { //doesnt exist in the database yet
                    $theReadingProgress = new Readingprogress();
                    $pagesDiff = $pages;
                } else {
                    $theReadingProgress = $readingProgresses[0];
                    if($pages - $readingProgresses[0]->getPagesRead() > 0) {
                        $pagesDiff = $pages - $readingProgresses[0]->getPagesRead();
                    }
                }

                $theReadingProgress->setUserId($userId);
                $theReadingProgress->setBookId($bookId);
                $theReadingProgress->setPagesRead($pages);
                $theReadingProgress->save();
                if($pagesDiff != 0) {
                    $this->addReadingProgressActivity($book->getTitle(), $pagesDiff);
                }


                $message = 'Reading progress updated/created';
                return $this->json(['message' => $message]);
            }


        }
        throw new HTTPException(400, 'Invalid request data');
    }


    public function getFollowing($bookId) : array {
        $readingList = Readinglist::getAll("book_id = ? ", [$bookId]);
        $userFollowings = Follow::getAll("follower_id = ?", [$this->app->getAuth()->getLoggedUserId()]);
        $userFollowingsId = [];
        foreach ($userFollowings as $userFollow) {
            $userFollowingsId[] = $userFollow->getFollowedId();
        }

        $followings = [];
        foreach ($readingList as $reading) {
            if(in_array($reading->getUserId(), $userFollowingsId)) {
                $profilePics = Profile::getAll("user_id = ?", [$reading->getUserId()]);
                $profilePic = $profilePics[0]->getProfilePicture();
                $followings[] = array(
                    'user_name' => User::getOne($reading->getUserId())->getUsername(),
                    'profile_pic' => $profilePic,
                    'status' => $reading->getStatus()
                );
            }
        }
        return $followings;
    }




    public function getStatusDistribution($bookId) : array {
        $readingList = Readinglist::getAll("book_id = ? ", [$bookId]);
        $readingCount = 0;
        $finishedCount = 0;
        $planningCount = 0;
        $d = [];

        foreach ($readingList as $reading) {
            switch ($reading->getStatus()) {
                case "reading":
                    $readingCount++;
                    break;
                case "planning":
                    $planningCount++;
                    break;
                case "finished":
                    $finishedCount++;
                    break;
            }
        }
        $d[] = array("readingCount" => $readingCount, "finishedCount" => $finishedCount, "planningCount" => $planningCount);

        return $d;
    }

    /**
     * @throws \JsonException
     */
    public function addAsFavoriteBook() {
        $data = $this->app->getRequest()->getRawBodyJSON();
        if (is_object($data) && property_exists($data, 'bookId')) {
            $bookId = $data->bookId;
            $favoriteBook = new FavoriteBook();
            $favoriteBook->setBookId($bookId);
            $favoriteBook->setUserId($this->app->getAuth()->getLoggedUserId());
            $favoriteBook->save();

            $message = 'OK';
            return $this->json(['message' => $message]);
        }

        $message = 'Something is missing';
        return $this->json(['message' => $message]);
    }

    public function removeAsFavoriteBook() {
        $data = $this->app->getRequest()->getRawBodyJSON();
        if (is_object($data) && property_exists($data, 'bookId')) {
            $bookId = $data->bookId;
            $favoriteBooks = FavoriteBook::getAll("book_id = ? AND user_id = ?", [$bookId, $this->app->getAuth()->getLoggedUserId()]);
            $favoriteBooks[0]->delete();
            $message = 'OK';
            return $this->json(['message' => $message]);
        }

        $message = 'Something is missing';
        return $this->json(['message' => $message]);
    }

    public function addFavoriteBookActivity($bookName) : void {
        $newActivity = new Activity();
        $newActivity->setUserId($this->app->getAuth()->getLoggedUserId());
        $newActivity->setActivityText("Added as favorite - {$bookName}");
        $newActivity->save();
    }

    public function addReadingProgressActivity($bookName, $pages) : void {
        $newActivity = new Activity();
        $newActivity->setUserId($this->app->getAuth()->getLoggedUserId());
        $newActivity->setActivityText("Read {$pages} of  {$bookName}");
        $newActivity->save();
    }

}