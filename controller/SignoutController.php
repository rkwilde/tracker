<?php
require_once("Controller.php");

class SignoutController extends Controller {

    public function __construct() {
        parent::__construct();
        unset($_SESSION['signedInID']);
        $this->redirectSignedOut();
    }

}