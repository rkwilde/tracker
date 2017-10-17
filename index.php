<?php
$debugMode = 0;
if ($debugMode) {
    ini_set('display_errors',1);
    error_reporting(E_ALL);
}
session_start();
$_SESSION['debugMode'] = $debugMode;

// look for page and call correct controller
    $getPage = (isset($_GET['page']) ? $_GET['page'] : 'welcome');

    switch($getPage) {
        case 'ajax':
            require_once('controller/AjaxController.php');
            new AjaxController();    
            break;
        case 'log':
            require_once('controller/LogController.php');
            new LogController();
            break;
        case 'signin':
            require_once('controller/SigninController.php');
            new SigninController();
            break;
        case 'signout':
            require_once('controller/SignoutController.php');
            new SignoutController();
            break;
        case 'signup':
            require_once('controller/SignupController.php');
            new SignupController();
            break;
        case 'welcome':
            require_once('controller/WelcomeController.php');
            new WelcomeController();
            break;
        case 'about':
            require_once('view/aboutView.php');
            break;
        case 'community':
            require_once('view/communityView.php');
            break; 
        case 'contact':
            require_once('view/contactView.php');
            break; 
        case 'main':
            require_once('view/mainView.php');
            break; 
        case 'privacy':
            require_once('view/privacyView.php');
            break; 
        case 'terms':
            require_once('view/termsView.php');
            break; 
        default:
            header('Location: index.php');
    }

?>
