<?php
require_once("Controller.php");

class WelcomeController extends Controller {

    public function __construct() {
        parent::__construct();
        if ($this->isSignedIn()) $this->redirectSignedIn();
        require_once('view/welcomeView.php');
    }

}