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
        return $this->html(["chosenBook" => $chosenBook]);
        //return $this->html();
    }

    /**
     * @throws \Exception
     */
    public function add() : Response {
        $formData = $this->request()->getPost();
        //$chosenBookId = $this->request()->getValue("id");
        $idBook = $this->request()->getValue("id");

        if(isset($formData['submit'])) {
            //$bookId = $this->request()->getValue("id");
            $newReview = new Review();
            $newReview->setBookId($idBook);


            $userUsername = $this->app->getAuth()->getLoggedUserName();
            $userIds = User::getAll('username = ?', [$this->app->getAuth()->getLoggedUserName()]);
            $userId = $userIds[0];

            $newReview->setUserId($userId->getId());

            $newReview->setReviewText($formData['review_text']);
            $newReview->setReviewAuthor($userUsername);
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

    }
}