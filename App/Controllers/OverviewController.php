<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Activity;
use App\Models\Book;
use App\Models\Follow;
use App\Models\Profile;
use App\Models\Review;
use App\Models\User;

class OverviewController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        $bestReviewedBooks = $this->getBestReviewedBooks();

        $followedUsersActivities = $this->getActivities();
        $followedUsersProfiles = $this->getAuthorsOfActivities($followedUsersActivities);
        return $this->html(["followedPeopleActivities" =>$followedUsersActivities, "followedUsersProfiles" => $followedUsersProfiles, "bestReviewedBooks"=>$bestReviewedBooks]);
    }


    public function getActivities(): array {
        $activities = [];
        $follows = Follow::getAll();

        foreach ($follows as $follow) {
            if ($follow->getFollowerId() == $this->app->getAuth()->getLoggedUserId()) {
                $followedPersonId = $follow->getFollowedId();
                $personActivities = Activity::getAll("user_id = ?", [$followedPersonId]);
                $activities = array_merge($activities, $personActivities); //https://www.w3schools.com/php/func_array_merge.asp
            }
        }

        return $activities;
    }


    public function getAuthorsOfActivities($activities) {
        $profiles = [];
        foreach ($activities as $activity) {
            $profile = Profile::getAll("user_id = ?", [$activity->getUserId()]);
            $profiles[] = $profile[0];
        }
        return $profiles;
    }

    public function getBestReviewedBooks() : array {
        $books = Book::getAll();
        $ratings = [];

        $bestRating = 0;
        $numberOfBooks = 4;
        foreach ($books as $book) {
            $ratings[] = array('id' => $book->getId(), 'rating' => $book->getAverageRating());
        }

        usort($ratings, function($a, $b) { return $b['rating'] <=> $a['rating']; });
        $topNBooks = array_slice($ratings, 0, 4);
        $bestReviewedBooks = [];
        foreach ($topNBooks as $entry) {
            $bestReviewedBooks[] = Book::getOne($entry['id']);
        }
        return $bestReviewedBooks; //https://www.geeksforgeeks.org/how-to-get-first-n-number-of-elements-from-an-array-in-php/

    }

    public function getRecentlyAddedBooks() {

    }

    public function getSimilarBooks() {

    }
}