<?php
require_once("Controller.php");

class LogController extends Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->isSignedIn()) $this->redirectSignedOut();
        // remaining users are already signed in
        require_once('view/logView.php');
    }

}