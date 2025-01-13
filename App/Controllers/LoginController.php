<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Profile;
use App\Models\User;

class LoginController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        return $this->html();
    }

    public function register() : Response
    {
        $message = $this->app->getRequest()->getValue('message');
        return $this->html(["message" => $message]);
    }

    /**
     * @throws \Exception
     */
    public function registerUser() : Response {
        $formData = $this->app->getRequest()->getPost();
        if(isset($formData['submit'])) {

            $existingUser = User::getAll("username = ?", [$formData['username']]);
            if (count($existingUser) > 0) {
                $message = "Username already used, try another";
                return $this->redirect($this->url("login.register", ["message" => $message]));
            }

            $existingUser = User::getAll("email = ?", [$formData['email']]);
            if (count($existingUser) > 0) {
                $message = "Email already used, try another";
                return $this->redirect($this->url("login.register", ["message" => $message]));
            }

            $newUser = new User();
            $newUser->setUsername($formData['username']);
            $newUser->setPassword(password_hash($formData['password'], PASSWORD_BCRYPT)); //hasovanie - https://www.php.net/manual/en/function.password-hash.php
            $newUser->setEmail($formData['email']);
            $newUser->setRoleId(1);
            $newUser->save(); //ulozenie do databazky

            $newProfile = new Profile();
            $newProfile->setUserId($newUser->getId());
            $newProfile->save();

            if($newUser->getId() > 0) { //user sa ulozil
                $logged = $this->app->getAuth()->login($formData['username'], $formData['password']); //bool value if the user is logged in
                if ($logged) {
                    return $this->redirect($this->url("booklist.index"));
                }

            } else {
                $message = "Unable to register, try again";
                return $this->redirect($this->url("login.register", ["message" => $message]));
            }
        }
        $message = "Unable to register, try again";
        return $this->redirect($this->url("login.register", ["message" => $message]));

    }

}