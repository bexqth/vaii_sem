<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Activity;
use App\Models\Book;
use App\Models\FavoriteBook;
use App\Models\Follow;
use App\Models\Genre;
use App\Models\Profile;
use App\Models\Readinglist;
use App\Models\Readingprogress;
use App\Models\Review;
use App\Models\User;

class ProfileController extends AControllerBase
{

    public function authorize(string $action)
    {
        switch ($action) {
            case "removeFollow":
            case "giveFollow":
                return $this->app->getAuth()->isLogged() && $this->app->getAuth()->isUser();
            default: return true;
        }
    }


    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        //$users = User::getAll('username = ?', [$this->app->getAuth()->getLoggedUserName()]);
        //$user = $users[0];
        //$user_id = $this->app->getAuth()->getLoggedUserId();
        $user_id = $this->app->getRequest()->getValue("userId");
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

        $nTopGenres = $this->getGenreOverview($user_id);
        $nTopGenresNames = array_column($nTopGenres, 'name');
        $nTopGenresCount = array_column($nTopGenres, 'count');

        $follows = Follow::getAll("follower_id = ? AND followed_id = ?", [$this->app->getAuth()->getLoggedUserId(), $user_id]);
        if(count($follows) == 0) {
            $isFollowing = false;
        } else {
            $isFollowing = true;
        }

        $favoriteBooks = $this->getFavoriteBooks($user_id);

        return $this->html(['user' => $user, 'readingBooks' => $readingBooks, 'finishedBooks' => $finishedBooks, 'planningBooks' => $planningBooks,
            'readingReviews' => $readingReviews, 'finishedReviews' => $finishedReviews, 'planningReviews' => $planningReviews,
            "readingProgresses" => $readingProgresses, "finishedProgresses" => $finishedProgresses, "planningProgresses" => $planningProgresses,
            "userProfile" => $user_profile, "isFollowing" => $isFollowing, "nTopGenresCount" => $nTopGenresCount, "nTopGenresNames" => $nTopGenresNames, "favoriteBooks" => $favoriteBooks,]);
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

    /**
     * @throws \Exception
     */
    public function editProfile() : Response {
        $data = $this->app->getRequest()->getFiles();
        $profile_pic = $this->app->getRequest()->getFiles()["profile_picture"];
        $banner_pic = $this->app->getRequest()->getFiles()["banner_picture"];
        $bio = $this->app->getRequest()->getValue("bio");
        $profile_pic_content = null;
        $banner_pic_content = null;

        if (isset($data["profile_picture"])) {
            $profile_pic = $data["profile_picture"]['tmp_name']; //temp location
            $profile_pic_content = file_get_contents($profile_pic); //binary rep
        }

        if (isset($data["banner_picture"])) {
            $banner_pic = $data["banner_picture"]['tmp_name'];
            $banner_pic_content = file_get_contents($banner_pic);
        }

        $user_id = $this->app->getAuth()->getLoggedUserId();
        $user_profiles = Profile::getAll("user_id = ?", [$user_id]);
        $user_profile = $user_profiles[0];

        $user_profile->setBio($bio);
        if ($profile_pic_content !== null) {
            $user_profile->setProfilePicture($profile_pic_content);
        }
        if ($banner_pic_content !== null) {
            $user_profile->setBannerPicture($banner_pic_content);
        }
        $user_profile->save();
        $message = 'Book added to reading list successfully';
        return $this->json(['message' => $message]);
    }

    /**
     * @throws \JsonException
     */
    public function giveFollow() {
        $data = $this->request()->getRawBodyJSON();
        if (is_object($data) && property_exists($data, 'profileId')) {
            $profileId = $data->profileId;
            $profiles = Profile::getAll("id = ?", [$profileId]);
            $followedPersonId = $profiles[0]->getUserId();
            $newFollow = new Follow();
            $newFollow->setFollowedId($followedPersonId);
            $newFollow->setFollowerId($this->app->getAuth()->getLoggedUserId());
            $newFollow->save();
            $followedPerson = User::getOne($followedPersonId);
            $this->addFollowActivity($followedPerson->getUsername());

            $user = User::getOne($followedPersonId);
            $followers = $user->getFollowers();
            $followings = $user->getFollowings();
            return $this->json(['followings' => $followings, "followers" => $followers]);
        }

        $message = 'Something is missing';
        return $this->json(['message' => $message]);
    }

    public function removeFollow() {
        $data = $this->request()->getRawBodyJSON();
        if (is_object($data) && property_exists($data, 'profileId')) {
            $profileId = $data->profileId;
            $profiles = Profile::getAll("id = ?", [$profileId]);
            $followedPersonId = $profiles[0]->getUserId();
            $follows = Follow::getAll("followed_id = ? AND follower_id = ?", [$followedPersonId, $this->app->getAuth()->getLoggedUserId()]);
            $follow = $follows[0];
            $follow->delete();

            $user = User::getOne($followedPersonId);
            $followers = $user->getFollowers();
            $followings = $user->getFollowings();
            return $this->json(['followings' => $followings, "followers" => $followers]);
        }
        $message = 'Something is missing';
        return $this->json(['message' => $message]);
    }

    public function addFollowActivity($name) : void {
        $newActivity = new Activity();
        $newActivity->setUserId($this->app->getAuth()->getLoggedUserId());
        $newActivity->setActivityText("Just started following {$name}");
        $newActivity->save();
    }

    public function getGenreOverview($userId) {
        $genres = Genre::getAll();
        $genreCounts = [];
        $readingLists = Readinglist::getAll("user_id = ?", [$userId]);

        foreach ($genres as $genre) {
            $genreCounts[$genre->getId()] = array(
                'id' => $genre->getId(),
                'count' => 0,
                'name' => $genre->getName(),
            );
        }

        foreach ($readingLists as $readingList) {
            $books = Book::getAll("id = ?", [$readingList->getBookId()]);
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
        return $topNGenres;

    }

    public function getFavoriteBooks($userId) : array {
        $favoriteBooks = FavoriteBook::getAll("user_id = ?", [$userId]);
        $books = [];
        foreach ($favoriteBooks as $favoriteBook) {
            $books[] = Book::getOne($favoriteBook->getBookId());
        }
        return $books;
    }

}

