<?php

/*
    requests should come in the $_POST array, including at least the variable 
    date, with optional variables calsToAdd, exToAdd, and notesToAdd
*/

// mysql connection
    require("config.php");
    $db = new PDO("mysql:host=$hostname;dbname=$database",$username,$pw);

//check for date
    if(!isset($_POST['date'])) returnFailure("No date given");
    $curDate = $_POST['date'];

// update stmts should only happen when curDate is already in database, so we'll do those first
    if (isset($_POST['calsToAdd'])) {
        $sql = $db->prepare(
            'UPDATE tracker_table 
                SET calories = IFNULL(calories,0) + ? 
                WHERE date = ? ');
        $sql->execute(array($_POST['calsToAdd'],$curDate));
    }
    if (isset($_POST['nullCals'])) {
        $sql = $db->prepare(
            'UPDATE tracker_table 
                SET calories = NULL 
                WHERE date = ? ');
        $sql->execute(array($curDate));

    }
    if (isset($_POST['exToAdd'])) {
        $sql = $db->prepare(
            'UPDATE tracker_table 
                SET exercise = IFNULL(exercise,0) + ? 
                WHERE date = ? ');
        $sql->execute(array($_POST['exToAdd'],$curDate));
    }
    if (isset($_POST['notesToAdd'])) {
        $sql = $db->prepare(
            'UPDATE tracker_table 
                SET notes = 
                    CONCAT(
                        notes,
                        if(notes="","","\n"),
                        ? ) 
                WHERE date = ? ');
        $sql->execute(array($_POST['notesToAdd'],$curDate));
    }
    if (isset($_POST['replaceNotes'])) {
        $sql = $db->prepare(
            'UPDATE tracker_table 
                SET notes = ? 
                WHERE date = ? ');
        $sql->execute(array($_POST['replaceNotes'],$curDate));
    }
    if(isset($_POST['tempToAdd'])) {
        $sql = $db->prepare(
            'UPDATE tracker_table 
                SET temp = 
                    CONCAT(
                        temp,
                        if(temp="","","\n"),
                        ? ) 
                WHERE date = ? ');
        $sql->execute(array($_POST['tempToAdd'],$curDate));
    }
    if (isset($_POST['replaceTemp'])) {
        $sql = $db->prepare(
            'UPDATE tracker_table 
                SET temp = ? 
                WHERE date = ? ');
        $sql->execute(array($_POST['replaceTemp'],$curDate));
    }


// see if day is already in database and return info
    $sql = $db->prepare(
        'SELECT 
            date, 
            IFNULL(calories,0) as calories, 
            IFNULL(exercise,0) as exercise, 
            notes,
            temp 
        FROM tracker_table 
        WHERE date=?');
    if(!($sql->execute(array($curDate)))) returnFailure("Query couldn't run"); 
    if($sql_result = $sql->fetch(PDO::FETCH_ASSOC)) {
        // return sql result for given date
        echoToAJAX(
            $sql_result['date'],
            $sql_result['calories'],
            $sql_result['exercise'],
            $sql_result['notes'],
            $sql_result['temp'],
            "return what's in database" );
    } else if ($sql->rowCount()==0) {
        // this means we need a new line.
            // while we're at it, we'll clean up temp
                $sql = $db->prepare(
                    'UPDATE  tracker_table
                        SET temp = ""
                        WHERE date < DATE_SUB(CURDATE(),INTERVAL 1 WEEK)
                        ');
                $sql->execute();
            // create line in database for new date
                $sql = $db->prepare(
                    'INSERT INTO 
                        tracker_table (date,notes,temp) 
                        VALUES (?,"","")');
                if($sql->execute(array($curDate)) && $sql->rowCount()>0) {
                    echoToAJAX($curDate,0,0,"","","created new row");
                } else returnFailure("Could not insert day in database");
    } else returnFailure("Could not access query results"); 


//functions
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