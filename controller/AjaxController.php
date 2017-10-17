<?php
require_once("Controller.php");
require_once("model/LogModel.php");

/*  requests should come in the $_POST/$post array, including at least 'date'.
        Other variables are to update database for given date */

class AjaxController extends Controller {

    // inherits $model
    private $date;
    private $userID;
    private $calories;
    private $exercise;
    private $notes;
    private $temp;
    private $msgCals = "";
    private $msgPerm = "";
    private $msgTemp = "";
    private $msgDetails = "";

    // set model and date, create date row if necessary (and clean temp)
    public function __construct() {
        $this->defaultMessages();
        $this->setUserID();
        try {
            parent::__construct(new LogModel($this->userID));
            $this->msgDetails .= "Instantiated controller and model. ";
        } catch (Exception $e) {
            $this->msgDetails .= "Couldn't create model:" . $e->getMessage() . ". ";
            $this->instToJSON();
        }
        
        $this->setDate();
        $this->createRowIfNew();
        $this->updateLog();
        $this->selectAndReturn();
    }
    
    // assume failure for all operations, to be changed upon success
    private function defaultMessages() {
        if (isset($_POST['calsToAdd']) || 
            isset($_POST['nullCals']) || 
            isset($_POST['exToAdd'])) {
            $this->msgCals = "An error occurred. Please contact site administrator. ";
        }
        if (isset($_POST['notesToAdd']) || 
            isset($_POST['replaceNotes'])) {
            $this->msgPerm = "An error occurred. Please contact site administrator. ";
        }
        if (isset($_POST['tempToAdd']) || 
            isset($_POST['replaceTemp'])) {
            $this->msgTemp = "An error occurred. Please contact site administrator. ";
        }
    }

    // set $this->userID from $_SESSION if possible
    private function setUserID() {
        if(!isset($_SESSION['signedInID'])) {
            $msgDetails .= "Missing UserID. ";
            $this->instToJSON();
        }
        $this->userID = $_SESSION['signedInID'];
    }

    // set $this->date from $_POST if possible
    private function setDate() {
        if(!isset($_POST['date'])) {
            $msgDetails .= "Missing date. ";
            $this->instToJSON();
        }
        // should add input validation...
        $this->date = $_POST['date'];
    }

    // if there's no row for the date, create one
    private function createRowIfNew() {
        if(!$this->model->dateRowExists($this->date)) {
            try {
                $this->model->insertDateRow($this->date);
                $this->msgDetails .= "Added new date row. ";
            } catch (Exception $e) {
                $this->msgDetails .= "Couldn't insert row:" . $e->getMessage() . ". ";
                $this->instToJSON();
            }
            $this->model->cleanTemp();
            $this->msgDetails .= "Deleted old temp notes. ";
        }
    }

    // updates to log
    private function updateLog() {
        if(isset($_POST['calsToAdd'])) {
            $this->model->addCals($_POST['calsToAdd'],$_POST['date']);
            $this->msgCals = "Added " . $_POST['calsToAdd'] . " calories. ";
        }
        if(isset($_POST['nullCals'])) { 
            $this->model->nullCals($_POST['date']);
            $this->msgCals = "Deleted calories. ";
        }
        if(isset($_POST['exToAdd']))  {
            $this->model->addExercise($_POST['exToAdd'],$_POST['date']);
            $this->msgCals = "Added " . $_POST['exToAdd'] . " exercise calories. ";
        }
        if(isset($_POST['notesToAdd'])) {
            $this->model->addNotes($_POST['notesToAdd'],$_POST['date']);
            $this->msgPerm = "Added new note. ";
        }
        if(isset($_POST['replaceNotes'])) {
            $this->model->replaceNotes($_POST['replaceNotes'],$_POST['date']);
            $this->msgPerm = "Replaced note. ";
        }
        if(isset($_POST['tempToAdd'])) {
            $this->model->addTemp($_POST['tempToAdd'],$_POST['date']);
            $this->msgTemp = "Added new note. ";
        }
        if(isset($_POST['replaceTemp'])) {
            $this->model->replaceTemp($_POST['replaceTemp'],$_POST['date']);
            $this->msgTemp = "Replaced note. ";
        }
    }

    // select date row and return
    private function selectAndReturn() {
        $result = $this->model->selectRowByDate($this->date);
        $this->calories = $result['calories'];
        $this->exercise = $result['exercise'];
        $this->notes = $result['notes'];
        $this->temp = $result['temp'];
        $this->msgDetails .= "Returned what's in database. ";
        $this->instToJSON();
    }

    // echo JSON result for current instance and die
    private function instToJSON() {
        self::toJSON(
            $this->date,
            $this->calories,
            $this->exercise,
            $this->notes,
            $this->temp,
            $this->msgCals,
            $this->msgPerm,
            $this->msgTemp,
            $this->msgDetails );
    }

    // echo out JSON result to respond to AJAX request, then die
    public static function toJSON($date,$c,$e,$n,$t,$msgCals,$msgPerm,$msgTemp,$msgDetails) {
        if (empty($_SESSION['debugMode'])) $msgDetails = "";
        $myArray = array(
            'date' => $date,
            'totalCalories' => $c,
            'totalExercise' => $e,
            'notes' => $n,
            'temp' => $t,
            'msgCals' => $msgCals,
            'msgPerm' => $msgPerm,
            'msgTemp' => $msgTemp,
            'msgDetails' => $msgDetails );
        echo json_encode($myArray);
        die();
    }
    public static function failToJSON($failMessage) {
        // echo (return to ajax) dateless result with zeroes
        self::toJSON("",0,0,"","","","","",$failMessage);
    }

}

?>