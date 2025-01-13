<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Activity;
use App\Models\Book;
use App\Models\Follow;
use App\Models\Genre;
use App\Models\Profile;
use App\Models\Readinglist;
use App\Models\Review;
use App\Models\User;
use DateTime;

class OverviewController extends AControllerBase
{

    public function authorize(string $action)
    {
        return $this->app->getAuth()->isLogged();
    }

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        $bestReviewedBooks = $this->getBestReviewedBooks();
        $recentlyAddedBooks = $this->getRecentlyAddedBooks();
        $similarBooks = $this->getSimilarBooks();

        $followedUsersActivities = $this->getActivities();
        $followedUsersProfiles = $this->getAuthorsOfActivities($followedUsersActivities);
        return $this->html(["followedPeopleActivities" =>$followedUsersActivities, "followedUsersProfiles" => $followedUsersProfiles, "bestReviewedBooks" => $bestReviewedBooks, "recentlyAddedBooks" => $recentlyAddedBooks, "similarBooks" => $similarBooks]);
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

        return array_reverse($activities);
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

        foreach ($books as $book) {
            $ratings[] = array('id' => $book->getId(), 'rating' => $book->getAverageRating());
        }

        usort($ratings, function($a, $b) { return $b['rating'] <=> $a['rating']; });
        $topNBooks = array_slice($ratings, 0, 6);
        $bestReviewedBooks = [];
        foreach ($topNBooks as $entry) {
            $bestReviewedBooks[] = Book::getOne($entry['id']);
        }
        return $bestReviewedBooks; //https://www.geeksforgeeks.org/how-to-get-first-n-number-of-elements-from-an-array-in-php/

    }

    /**
     * @throws \DateMalformedStringException
     */
    public function getRecentlyAddedBooks() {
        $books = Book::getAll();
        $recentlyAddedBooks = [];
        foreach ($books as $book) {
            $date = new DateTime($book->getCreatedAt());
            $recentlyAddedBooks[] = array('id' => $book->getId(), 'date' => $date->format('d-m-Y'));
        }

        usort($recentlyAddedBooks, function($a, $b) { return $b['date'] <=> $a['date']; });

        $topNBooks = array_slice($recentlyAddedBooks, 0, 6);
        $books = [];
        foreach ($topNBooks as $entry) {
            $books[] = Book::getOne($entry['id']);
        }
        return $books;
    }

    public function getSimilarBooks() {
        $genres = Genre::getAll();
        $genreCounts = [];
        $readingList = Readinglist::getAll("user_id = ?", [$this->app->getAuth()->getLoggedUserId()]);
        $allBooks = Book::getAll();
        $readingBookIds = [];

        foreach ($readingList as $reading) {
            $readingBookIds[] = $reading->getBookId();
        }

        foreach ($genres as $genre) {
            $genreCounts[$genre->getId()] = array(
                'id' => $genre->getId(),
                'count' => 0,
                'name' => $genre->getName(),
            );
        }

        foreach ($readingList as $list) {
            $books = Book::getAll("id = ?", [$list->getBookId()]);
            foreach ($books as $book) {
                foreach ($genres as $genre) {
                    if($book->getGenreId() == $genre->getId()) {
                        $genreCounts[$book->getGenreId()]['count']++;
                    }
                }

            }
        }

        usort($genreCounts, function($a, $b) { return $b['count'] <=> $a['count']; });
        $topNGenres = array_slice($genreCounts, 0, 6);
        $recommendedBooks = [];
        $topGenreIds = array_column($topNGenres, 'id');

        foreach ($allBooks as $book) {
            if (!in_array($book->getId(), $readingBookIds)) {
                if (in_array($book->getGenreId(), $topGenreIds)) {
                    $recommendedBooks[] = $book;
                }
            }
        }
        return array_slice($recommendedBooks, 0, 6);
    }
}