<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Readingprogress;
use App\Models\User;

class ReadingprogressController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        // TODO: Implement index() method.
    }

    /**
     * @throws \JsonException
     * @throws \Exception
     */
    public function editReadingProgress() {
        $data = $this->request()->getRawBodyJSON();

        if (is_object($data) && property_exists($data, 'bookId') && property_exists($data, "pages")) {
            $bookId = $data->bookId;
            $pages = $data->pages;

            $users = User::getAll('username = ?', [$this->app->getAuth()->getLoggedUserName()]);
            $userIds = $users[0];
            $userId = $userIds->getId();

            $readingProgresses = Readingprogress::getAll("user_id = ? AND book_id = ?", [$userId, $bookId]);


            if($readingProgresses == null) { //doesnt exist in the database yet
                $newReadingProgress = new Readingprogress();
                $newReadingProgress->setUserId($userId);
                $newReadingProgress->setBookId($bookId);
                $newReadingProgress->setPagesRead($pages);
                $newReadingProgress->save();
            } else {
                $readingProgress = $readingProgresses[0];
                $readingProgress->setUserId($userId);
                $readingProgress->setBookId($bookId);
                $readingProgress->setPagesRead($pages);
                $readingProgress->save();
            }
        }
    }
}