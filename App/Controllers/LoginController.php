<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
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

    public function login(): Response
    {
        return $this->html();
    }

    public function logout(): Response {
        return $this->html();
    }

    public function register() : Response
    {
        return $this->html();
    }

    /**
     * @throws \Exception
     */
    public function registerUser() : Response{
        $formData = $this->app->getRequest()->getPost();

        if(isset($formData['submit'])) {
            $newUser = new User();
            $newUser->setUsername($formData['username']);
            $newUser->setPassword(password_hash($formData['password'], PASSWORD_BCRYPT)); //hasovanie - https://www.php.net/manual/en/function.password-hash.php
            $newUser->setEmail($formData['email']);


            $newUser->save(); //ulozenie do databazky

            if($newUser->getId() > 0) { //ci je v database
                $logged = $this->app->getAuth()->login($formData['username'], $formData['password']); //bool value if the user is logged in
                if ($logged) {
                    return $this->redirect($this->url("booklist.index"));
                }

            } else {
                $data = ['message' => 'Failed to register user. Please try again.'];
                return $this->html($data);
            }

        }
        //return $this->html();
        return $this->redirect($this->url("login.register"));

    }

    public function loginUser() {

    }

    public function logoutUser() {

    }
}