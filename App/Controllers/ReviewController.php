<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Book;
use App\Models\Review;
use App\Models\User;

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

        if($review == null) {
            $review = new Review();
            $review->setBookId($chosenBookId);
            $userIds = User::getAll('username = ?', [$this->app->getAuth()->getLoggedUserName()]);
            $userId = $userIds[0];
            $review->setUserId($userId->getId());
            $userUsername = $this->app->getAuth()->getLoggedUserName();
            $review->setReviewAuthor($userUsername);
            $review->save();
        }

        return $this->html(['chosenBook' => $chosenBook, "review" => $review]);
        //return $this->html();
    }

    /**
     * @throws \Exception
     */
    public function add() : Response {
        $formData = $this->request()->getPost();
        //$chosenBookId = $this->request()->getValue("id");
        $idBook = $this->request()->getValue("id");
        $idReview = $this->request()->getValue("reviewId"); //this working
        $review = Review::getOne($idReview);

        $userUsername = $this->app->getAuth()->getLoggedUserName();

        if(isset($formData['submit'])) {

            /*if($review == null) {
                //$newReview = new Review();
                //$newReview->setBookId($idBook);
                //$userIds = User::getAll('username = ?', [$this->app->getAuth()->getLoggedUserName()]);
                //$userId = $userIds[0];
                //$newReview->setUserId($userId->getId());
                //$newReview->setReviewAuthor($userUsername);
            } else {
                $newReview = $review;
            }*/

            //$bookId = $this->request()->getValue("id");
            //dfsd
            $newReview = $review;
            $newReview->setReviewText($formData['review_text']);
            $newReview->setRating($formData['rating']);

            $newReview->save();

            //$userId = $this->app->getAuth()->getLoggedUserName()

            //$newReview->setCreatedAt(new \DateTime());
            //$newReview->save();
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