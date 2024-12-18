<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Book;
use App\Models\Profile;
use App\Models\Readinglist;
use App\Models\Readingprogress;
use App\Models\Review;
use App\Models\User;

class ProfileController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        //$users = User::getAll('username = ?', [$this->app->getAuth()->getLoggedUserName()]);
        //$user = $users[0];
        $user_id = $this->app->getAuth()->getLoggedUserId();
        $user = User::getOne($user_id);
        $user_profiles = Profile::getAll("user_id = ?", [$user_id]);
        $user_profile = $user_profiles[0];
        //$user = User::getOne($user->getId());
        $readingListReading = Readinglist::getAll('user_id = ? AND status = ?', [$user_id, 'reading']);
        $readingListFinished = Readinglist::getAll('user_id = ? AND status = ?', [$user_id, 'finished']);
        $readingListPlanning = Readinglist::getAll('user_id = ? AND status = ?', [$user_id, 'planning']);

        $readingBooks = $this->getBooksFromList($readingListReading);
        $finishedBooks = $this->getBooksFromList($readingListFinished);
        $planningBooks = $this->getBooksFromList($readingListPlanning);

        $readingReviews = $this->getReviewsFromBooks($readingBooks);
        $finishedReviews = $this->getReviewsFromBooks($finishedBooks);
        $planningReviews = $this->getReviewsFromBooks($planningBooks);

        $readingProgresses = $this->getProgresses($readingBooks);
        $finishedProgresses = $this->getProgresses($finishedBooks);
        $planningProgresses = $this->getProgresses($planningBooks);

        return $this->html(['user' => $user, 'readingBooks' => $readingBooks, 'finishedBooks' => $finishedBooks, 'planningBooks' => $planningBooks,
            'readingReviews' => $readingReviews, 'finishedReviews' => $finishedReviews, 'planningReviews' => $planningReviews,
            "readingProgresses" => $readingProgresses, "finishedProgresses" => $finishedProgresses, "planningProgresses" => $planningProgresses,
            "userProfile" => $user_profile]);
    }

    public function getProgresses($books): array {
        $user_id = $this->app->getAuth()->getLoggedUserId();
        $progresses = [];
        if($books != null) {
            foreach ($books as $book) {
                $progress = Readingprogress::getAll('book_id = ? AND user_id = ?', [$book->getId(), $user_id]);
                if(count($progress) > 0) {
                    $progresses[] = $progress[0]->getPagesRead();
                } else {
                    $progresses[] = 0;
                }

            }
            return $progresses;
        }
        return $progresses;
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

    public function settings() : Response {
        $user_id = $this->app->getAuth()->getLoggedUserId();
        $user_profiles = Profile::getAll("user_id = ?", [$user_id]);
        $user_profile = $user_profiles[0];
        return $this->html(["profile" => $user_profile]);
    }
}

