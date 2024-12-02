<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Book;
use App\Models\Readinglist;
use App\Models\Review;
use App\Models\User;

class ProfileController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        $users = User::getAll('username = ?', [$this->app->getAuth()->getLoggedUserName()]);
        $user = $users[0];
        $user = User::getOne($user->getId());
        $readingListReading = Readinglist::getAll('user_id = ? AND status = ?', [$user->getId(), 'reading']);
        $readingListFinished = Readinglist::getAll('user_id = ? AND status = ?', [$user->getId(), 'finished']);
        $readingListPlanning = Readinglist::getAll('user_id = ? AND status = ?', [$user->getId(), 'planning']);

        $readingBooks = $this->getBooksFromList($readingListReading);
        $finishedBooks = $this->getBooksFromList($readingListFinished);
        $planningBooks = $this->getBooksFromList($readingListPlanning);

        $readingReviews = $this->getReviewsFromBooks($readingBooks);
        $finishedReviews = $this->getReviewsFromBooks($finishedBooks);
        $planningReviews = $this->getReviewsFromBooks($planningBooks);

        return $this->html(['user' => $user, 'readingBooks' => $readingBooks, 'finishedBooks' => $finishedBooks, 'planningBooks' => $planningBooks,
            'readingReviews' => $readingReviews, 'finishedReviews' => $finishedReviews, 'planningReviews' => $planningReviews,]);
    }


    public function getBooksFromList($list): array
    {
        $books = [];
        foreach ($list as $item) {
            $book = Book::getOne($item->getBookId());
            $books[] = $book;
        }
        return $books;
    }

    public function getReviewsFromBooks($books): array {
        $reviews = [];
        if($books != null) {
            foreach ($books as $book) {
                $review = Review::getAll('book_id = ?', [$book->getId()]);
                if(count($review) > 0) {
                    $reviews[] = $review[0];
                } else {
                    $reviews[] = null;
                }

            }
            return $reviews;
        }
        return $reviews;
    }
}