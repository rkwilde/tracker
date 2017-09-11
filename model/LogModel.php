<?php
require_once("Model.php");

// Model connects to and queries the database
class LogModel extends Model {

    // inherit $db, $userTable, $logTable

    public function __construct() {
        parent::__construct();  // creates db connection, sets $logTable
    }

    // update calories, exercise, notes in SQL
    function addCals($calsToAdd,$date) {
        $sql = $this->db->prepare(
            "UPDATE $this->logTable
                SET calories = IFNULL(calories,0) + ?
                WHERE date = ? ");
        $sql->execute(array($calsToAdd,$date));
    }
    function nullCals($date) {
        $sql = $this->db->prepare(
            "UPDATE $this->logTable
                SET calories = NULL
                WHERE date = ? ");
        $sql->execute(array($date));
    }
    function addExercise($exToAdd,$date) {
        $sql = $this->db->prepare(
            "UPDATE $this->logTable
                SET exercise = IFNULL(exercise,0) + ?
                WHERE date = ? ");
        $sql->execute(array($exToAdd,$date));
    }
    function addNotes($notesToAdd,$date) {
        $sql = $this->db->prepare(
            'UPDATE ' . $this->logTable . '
                SET notes =
                  CONCAT(
                      notes,
                      if(notes="","","\n"),
                      ? )
                WHERE date = ? ' );
        $sql->execute(array($notesToAdd,$date));
    }
    function replaceNotes($replaceNotes,$date) {
        $sql = $this->db->prepare(
            "UPDATE $this->logTable
                SET notes = ?
                WHERE date = ? " );
        $sql->execute(array($replaceNotes,$date));
    }
    function addTemp($tempToAdd,$date) {
        $sql = $this->db->prepare(
            'UPDATE ' . $this->logTable . '
                SET temp =
                    CONCAT(
                        temp,
                        if(temp="","","\n"),
                        ? )
                WHERE date = ? ');
        $sql->execute(array($tempToAdd,$date));
    }
    function replaceTemp($replaceTemp,$date) {
        $sql = $this->db->prepare(
            "UPDATE $this->logTable
                SET temp = ?
                WHERE date = ? ");
        $sql->execute(array($replaceTemp,$date));
    }


    // check if row exists for date
    function dateRowExists($date) {
        $sql = $this->db->prepare(
            "SELECT 1
                FROM $this->logTable
                WHERE date = ? 
                LIMIT 1 ");
        $sql->execute(array($date)); 
        return ($sql->rowCount()>0);
    }
    
    // insert row for new date
    function insertDateRow($date) {
        $sql = $this->db->prepare(
            'INSERT INTO
                ' . $this->logTable . ' (date,notes,temp)
                VALUES (?,"","")');
        $sql->execute(array($date));
        return $sql->rowCount()>0;
    }

    // clean up temporary stuff from over a week ago
    function cleanTemp() {
        $sql = $this->db->prepare(
            "UPDATE  $this->logTable
                SET temp = ''
                WHERE date < DATE_SUB(CURDATE(),INTERVAL 1 WEEK)
                ");
        $sql->execute();
    }

    // select row and return associative array
    function selectRowByDate($date) {
        $sql = $this->db->prepare(
            "SELECT
                date,
                IFNULL(calories,0) as calories,
                IFNULL(exercise,0) as exercise,
                notes,
                temp
            FROM $this->logTable
            WHERE date=?");
        $sql->execute(array($date));
        if ($sql->rowCount()==0) return NULL;
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

}

?>
