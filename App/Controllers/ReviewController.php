<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Book;
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

        $reviewId = $this->request()->getValue("reviewId");
        $review = Review::getOne($reviewId);

        $errorMessage = $this->request()->getValue("errorMessage");

        return $this->html(['chosenBook' => $chosenBook, "review" => $review, "errorMessage" => $errorMessage]);
    }

    /**
     * @throws \Exception
     */
    public function add() : Response {
        $formData = $this->request()->getPost();
        $idBook = $this->request()->getValue("id");
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

    public function edit() : Response {
        $reviewId = $this->request()->getValue("id");
        $review = Review::getOne($reviewId);
        $chosenBookId = $review->getBookId();
        $chosenBook = Book::getOne($chosenBookId);
        //return $this->html(["chosenBook" => $chosenBook, "review" => $review]);
        return $this->redirect($this->url("review.index", ["id" => $chosenBookId, "reviewId" => $reviewId]));
    }
}