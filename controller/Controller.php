<?php

class Controller {

    public $model;

    public function __construct(Model $model = null) {
        $this->model = $model;
    }

    public function setModel(Model $model) {
        $this->model = $model;
    }

    public function signIn($userID) {
        $_SESSION['signedInID'] = $userID;
    }

    public function isSignedIn() {
        return (
            isset($_SESSION['signedInID']) 
        );
    }

    public function redirectSignedIn() {
        header('Location: index.php?page=log');
    }

    public function redirectSignedOut() {
        header('Location: index.php?page=welcome');
    }

}