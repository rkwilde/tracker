<?php

/*
    requests should come in the $_POST array, including at least the variable
    date, with optional variables calsToAdd, exToAdd, and notesToAdd
*/

// receive AJAX requests
    require("./../model/db.php");
    require("./../config.php");

// check for date
    $curdate = "";
    if(!isset($_POST['date'])) {
        returnFailure("No date given");
    } else {
        $curDate = $_POST['date'];
    }

// mysql connection
    $db = new dbConnection($hostname,$database,$username,$pw,$table,$curDate);

// update stmts (these can only happen when curDate is already in database)
    if(isset($_POST['calsToAdd'])) $db->addCals($_POST['calsToAdd']);
    if(isset($_POST['nullCals'])) $db->nullCals();
    if(isset($_POST['exToAdd'])) $db->addExercise($_POST['exToAdd']);
    if(isset($_POST['notesToAdd'])) $db->addNotes($_POST['notesToAdd']);
    if(isset($_POST['replaceNotes'])) $db->replaceNotes($_POST['replaceNotes']);
    if(isset($_POST['tempToAdd'])) $db->addTemp($_POST['tempToAdd']);
    if(isset($_POST['replaceTemp'])) $db->replaceTemp($_POST['replaceTemp']);

// see if day is already in database and return info
    $sql_result = $db->selectRowByDate();
    if(count($sql_result)>0) {  // day's row already exists
        echoToAJAX(
            $sql_result['date'],
            $sql_result['calories'],
            $sql_result['exercise'],
            $sql_result['notes'],
            $sql_result['temp'],
            "return what's in database" );
    } else if (count($sql_result)==0) {   // day's row needs to be created
        if($db->insertDateRow())
            echoToAJAX($curDate,0,0,"","","created new row");
    }






//--------FUNCTIONS----------
    // echo out JSON result to respond to AJAX request, then die
    function echoToAJAX($d,$c,$e,$n,$t,$s) {
        $myArray = array(
            'date' => $d,
            'totalCalories' => $c,
            'totalExercise' => $e,
            'notes' => $n,
            'temp' => $t,
            'status' => $s );
        echo json_encode($myArray);
        die();
    }
    function returnFailure($failNote) {
        // echo (return to ajax) dateless result with zeroes
        echoToAJAX("",0,0,"","",$failNote);
    }

?>
