<?php
require_once("Model.php");

// Model connects to and queries the database
class LogModel extends Model {

    // inherit $db, $userTable, $logTable
    protected $userID;

    public function __construct($userID) {
        parent::__construct();  // creates db connection, sets $logTable
        $this->userID = $userID;
    }

    // update calories, exercise, notes in SQL
    function addCals($calsToAdd,$date) {
        $sql = $this->db->prepare(
            "UPDATE " . $this->logTable . "
                SET calories = IFNULL(calories,0) + ?
                WHERE person_id = ?
                    AND date = ? ");
        $sql->execute(array($calsToAdd,$this->userID,$date));
    }
    function nullCals($date) {
        $sql = $this->db->prepare(
            "UPDATE " . $this->logTable . "
                SET calories = NULL
                WHERE person_id = ?
                    AND date = ? ");
        $sql->execute(array($this->userID,$date));
    }
    function addExercise($exToAdd,$date) {
        $sql = $this->db->prepare(
            "UPDATE " . $this->logTable . "
                SET exercise = IFNULL(exercise,0) + ?
                WHERE person_id = ?
                    AND date = ? ");
        $sql->execute(array($exToAdd,$this->userID,$date));
    }
    function addNotes($notesToAdd,$date) {
        $sql = $this->db->prepare(
            'UPDATE ' . $this->logTable . '
                SET notes =
                  CONCAT(
                      notes,
                      if(notes="","","\n"),
                      ? )
                WHERE person_id = ?
                    AND date = ? ' );
        $sql->execute(array($notesToAdd,$this->userID,$date));
    }
    function replaceNotes($replaceNotes,$date) {
        $sql = $this->db->prepare(
            "UPDATE " . $this->logTable . "
                SET notes = ?
                WHERE person_id = ?
                    AND date = ? " );
        $sql->execute(array($replaceNotes,$this->userID,$date));
    }
    function addTemp($tempToAdd,$date) {
        $sql = $this->db->prepare(
            'UPDATE ' . $this->logTable . '
                SET temp =
                    CONCAT(
                        temp,
                        if(temp="","","\n"),
                        ? )
                WHERE person_id = ?
                    AND date = ? ');
        $sql->execute(array($tempToAdd,$this->userID,$date));
    }
    function replaceTemp($replaceTemp,$date) {
        $sql = $this->db->prepare(
            "UPDATE " . $this->logTable . "
                SET temp = ?
                WHERE person_id = ?
                    AND date = ? ");
        $sql->execute(array($replaceTemp,$this->userID,$date));
    }


    // check if row exists for date
    function dateRowExists($date) {
        $sql = $this->db->prepare(
            "SELECT 1
                FROM " . $this->logTable . "
                WHERE person_id = ?
                    AND date = ? 
                LIMIT 1 ");
        $sql->execute(array($this->userID,$date)); 
        return ($sql->rowCount()>0);
    }
    
    // insert row for new date
    function insertDateRow($date) {
        $sql = $this->db->prepare(
            'INSERT INTO ' . $this->logTable . 
                ' (date,notes,temp,person_id) VALUES (?,"","",?)');
        $sql->execute(array($date,$this->userID));
        if ($sql->rowCount()<=0) throw new RuntimeException(
            "no row inserted. logTable:  date: $date, userID: $this->userID");
        return true;
    }

    // clean up temporary stuff from over a week ago
    function cleanTemp() {
        $sql = $this->db->prepare(
            "UPDATE " . $this->logTable . "
                SET temp = ''
                WHERE person_id = ?
                    AND date < DATE_SUB(CURDATE(),INTERVAL 1 WEEK)
                ");
        $sql->execute(array($this->userID));
    }

    // select row and return associative array
    function selectRowByDate($date) {
        $sql = $this->db->prepare(
            "SELECT
                date,
                person_id,
                IFNULL(calories,0) as calories,
                IFNULL(exercise,0) as exercise,
                notes,
                temp
            FROM " . $this->logTable . "
            WHERE person_id = ?
                AND date=?");
        $sql->execute(array($this->userID,$date));
        if ($sql->rowCount()==0) return NULL;
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

}

?>
