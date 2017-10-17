<?php
require_once("Controller.php");
require_once("model/UserModel.php");

class SigninController extends Controller {

    public function __construct() {
        parent::__construct(new UserModel());
        // redirect users already signed in 
        if ($this->isSignedIn()) $this->redirectSignedIn();
        // if form has been submitted
        if (isset($_POST['signin_submit'])) {
            try {
                $this->checkCredentials();
            } catch (RuntimeException $e) {
                $message = $e->getMessage();
                require_once('view/signupView.php');
                die();
            }
        }
        // still not signed in -- shouldn't really happen without form submission
        header('Location: index.php');        
    }

    private function checkCredentials() {
        if (empty($_POST['email'])) throw new RuntimeException('No email provided');
        if (empty($_POST['pw'])) throw new RuntimeException('No password provided');
        try {
            $userID = $this->model->getUserID($_POST['email'],$_POST['pw']);
            $this->signIn($userID);
            $this->redirectSignedIn();
        } catch (RuntimeException $e) {
            throw $e;
        }
    }
}
