<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Core\Responses\RedirectResponse;
use App\Models\Activity;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Review;
use App\Models\User;
use Exception;

class ReviewController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        $chosenBookId = $this->request()->getValue("id");
        $chosenBook = Book::getOne($chosenBookId);
        $bookAuthor = Author::getOne($chosenBook->getAuthorId());

        $reviewId = $this->request()->getValue("reviewId");
        $review = Review::getOne($reviewId);

        $errorMessage = $this->request()->getValue("errorMessage");

        return $this->html(['chosenBook' => $chosenBook, "review" => $review, "errorMessage" => $errorMessage, "bookAuthor" => $bookAuthor]);
    }

    public function authorize(string $action): bool
    {
        if (!$this->app->getAuth()->isLogged()) {
            return false;
        }

        $user = User::getOne($this->app->getAuth()->getLoggedUserId());

        switch ($action) {
            case 'add':
                return $user->isUser();
            case 'edit':
                $reviewId = $this->request()->getValue("id");
                $review = Review::getOne($reviewId);
                return $review->getUserId() == $user->getId() && $user->isUser();
            case 'delete':
                $reviewId = $this->request()->getValue("id");
                $review = Review::getOne($reviewId);
                return $review->getUserId() == $user->getId() || $user->isAdmin();
            case "index":
                return $this->app->getAuth()->isUser();
            default:
                return false;
        }
    }

    /**
     * @throws \Exception
     */
    public function add() : Response {
        $formData = $this->request()->getPost();
        $idBook = $this->request()->getValue("id");
        $bookName = Book::getOne($idBook)->getTitle();
        $idReview = $this->request()->getValue("reviewId"); //this working
        $review = Review::getOne($idReview);

        $reviewText = $formData['review_text'];
        $reviewRating = $formData['rating'];

        if($reviewText == null || $reviewText == "") {
            $errorMessage = "Review text cannot be empty.";
            return $this->redirect($this->url("review.index", ["id" => $idBook, "reviewId" => $idReview, "errorMessage" => $errorMessage]));
        }

        if ($reviewRating < 1 || $reviewRating > 10 || empty($reviewRating)) {
            $errorMessage =  "Rating must be between 1 and 10.";
            return $this->redirect($this->url("review.index", ["id" => $idBook, "reviewId" => $idReview, "errorMessage" => $errorMessage]));
        }

        $maxReviewLength = 255;
        if (strlen($reviewText) > $maxReviewLength) {
            $errorMessage = "Review text cannot exceed $maxReviewLength characters.";
            return $this->redirect($this->url("review.index", ["id" => $idBook, "reviewId" => $idReview, "errorMessage" => $errorMessage]));
        }
        $userUsername = $this->app->getAuth()->getLoggedUserName();

        if(isset($formData['submit'])) {

            if($review == null) {
                $newReview = new Review();
                $newReview->setBookId($idBook);
                $userIds = User::getAll('username = ?', [$this->app->getAuth()->getLoggedUserName()]);
                $userId = $userIds[0];
                $newReview->setUserId($userId->getId()); //REFACTOR THIS CODE PLEASE
                //$newReview->setReviewAuthor($userUsername);
            } else {
                $newReview = $review;
            }

            $newReview->setReviewText($formData['review_text']);
            $newReview->setRating($formData['rating']);
            $newReview->save();
            $this->addReviewActivity($bookName);

            return $this->redirect($this->url("book.index", ["id" => $idBook]));

        }
        return $this->html(['message' => 'Failed to submit review.']);
    }

    /**
     * @throws \Exception
     */

    public function delete() : Response {
        $reviewId = $this->request()->getValue("id");
        $review = Review::getOne($reviewId);
        $idBook = $review->getBookId();
        $review->delete();
        return $this->redirect($this->url("book.index", ["id" => $idBook]));
    }

    public function edit(): Response
    {
        $reviewId = $this->request()->getValue("id");
        $review = Review::getOne($reviewId);
        $chosenBookId = $review->getBookId();
        $chosenBook = Book::getOne($chosenBookId);
        $bookAuthor = Author::getOne($chosenBook->getAuthorId());
        //return $this->html(["chosenBook" => $chosenBook, "review" => $review]);
        return $this->redirect($this->url("review.index", ["id" => $chosenBookId, "reviewId" => $reviewId, "bookAuthor" => $bookAuthor]));
        //return new RedirectResponse($this->url("review.index", ["id" => $chosenBookId, "reviewId" => $reviewId]));
    }

    public function addReviewActivity($bookName) : void {
        $newActivity = new Activity();
        $newActivity->setUserId($this->app->getAuth()->getLoggedUserId());
        $newActivity->setActivityText("Left review under {$bookName}");
        $newActivity->save();
    }
}