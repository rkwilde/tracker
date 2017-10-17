<?php
require_once("Controller.php");
require_once("model/UserModel.php");

class SignupController extends Controller {

    public function __construct() {
        parent::__construct(new UserModel());
        // redirect users already signed in
        if ($this->isSignedIn()) $this->redirectSignedIn();
        // if form has been submitted
        if (isset($_POST['signup_submit'])) {
            try {
                $this->createCredentials();
            } catch (RuntimeException $e) {
                $message = $e->getMessage();
            }
        }
        // still not signed in -- either navigating to signup page or just failed signing up 
        require_once('view/signupView.php');
    }

    private function createCredentials() {
        if (empty($_POST['email'])) throw new RuntimeException('No email provided');
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) throw new RuntimeException('Invalid email') ;
        if (empty($_POST['pw'])) throw new RuntimeException('No password provided');
        $regex = "/^.{8}/";
        if(!preg_match($regex,$_POST['pw'])) throw new RuntimeException('Password must be at least 8 characters');
        if (empty($_POST['re_pw'])) throw new RuntimeException('Please confirm password');
        if ($_POST['pw']!==$_POST['re_pw']) throw new RuntimeException("Passwords don't match");
        try {
            $userID = $this->model->addUserAndGetUserID($_POST['email'],$_POST['pw']);
            $this->signIn($userID);
            $this->redirectSignedIn();
        } catch (RuntimeException $e) {
            throw $e;
        }
    }

}