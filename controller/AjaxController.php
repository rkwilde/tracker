<?php
require_once("Controller.php");

/*  requests should come in the $_POST/$post array, including at least 'date'.
        Other variables are to update database for given date */

class AjaxController extends Controller {

    // inherits $model
    private $p;
    private $date;
    private $calories;
    private $exercise;
    private $notes;
    private $temp;
    private $message = "";

    // set model and date, create date row if necessary (and clean temp)
    public function __construct(LogModel $model, $post) {
        parent::__construct($model);  // sets $model
        $this->p = $post;
        
        $this->setDateOrFail();
        $this->createRowIfNew();
        $this->updateLog();
        
        $this->selectAndReturn();
    }
    
    // set $this->date from $this->p if possible
    private function setDateOrFail() {
        if(!isset($this->p['date'])) 
            self::failToJSON("Missing date");  // should add input validation
        $this->date = $this->p['date'];
    }

    // if there's no row for the date, create one
    private function createRowIfNew() {
        if(!$this->model->dateRowExists($this->date)) {
            $this->model->insertDateRow($this->date);
            $this->model->cleanTemp();
            $this->message .= "Added new date row. ";
        }
    }

    // updates to log
    private function updateLog() {
        if(isset($this->p['calsToAdd'])) {
            $this->model->addCals($this->p['calsToAdd'],$this->p['date']);
            $this->message .= "Added " . $this->p['calsToAdd'] . " calories. ";
        }
        if(isset($this->p['nullCals'])) { 
            $this->model->nullCals($this->p['date']);
            $this->message .= "Set calories to null. ";
        }
        if(isset($this->p['exToAdd']))  {
            $this->model->addExercise($this->p['exToAdd'],$this->p['date']);
            $this->message .= "Added " . $this->p['exToAdd'] . " exercise calories. ";
        }
        if(isset($this->p['notesToAdd'])) {
            $this->model->addNotes($this->p['notesToAdd'],$this->p['date']);
            $this->message .= "Added new note. ";
        }
        if(isset($this->p['replaceNotes'])) {
            $this->model->replaceNotes($this->p['replaceNotes'],$this->p['date']);
            $this->message .= "Replaced note. ";
        }
        if(isset($this->p['tempToAdd'])) {
            $this->model->addTemp($this->p['tempToAdd'],$this->p['date']);
            $this->message .= "Added new temp note. ";
        }
        if(isset($this->p['replaceTemp'])) {
            $this->model->replaceTemp($this->p['replaceTemp'],$this->p['date']);
            $this->message .= "Replaced temp note. ";
        }
    }

    // select date row and return
    private function selectAndReturn() {
        $result = $this->model->selectRowByDate($this->date);
        $this->calories = $result['calories'];
        $this->exercise = $result['exercise'];
        $this->notes = $result['notes'];
        $this->temp = $result['temp'];
        $this->message .= "Returned what's in database. ";
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
            $this->message);
    }

    // echo out JSON result to respond to AJAX request, then die
    public static function toJSON($date,$c,$e,$n,$t,$message) {
        $myArray = array(
            'date' => $date,
            'totalCalories' => $c,
            'totalExercise' => $e,
            'notes' => $n,
            'temp' => $t,
            'message' => $message );
        echo json_encode($myArray);
        die();
    }
    public static function failToJSON($failNote) {
        // echo (return to ajax) dateless result with zeroes
        self::toJSON("",0,0,"","",$failNote);
    }

}

?>