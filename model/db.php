<?php

// dbConnection connects to and queries the database
class dbConnection {
    
    private $db;
    private $date;
    private $table;
    public function dbConnection($host,$dbname,$username,$pw,$tableName,$curDate) {
        $this->db = new PDO("mysql:host=$host;dbname=$dbname","$username","$pw");
        $this->date = $curDate;
        $this->table = $tableName;
    }

    // update calories, exercise, notes in SQL
    function addCals($calsToAdd) {
        $sql = $this->db->prepare(
            "UPDATE $this->table
                SET calories = IFNULL(calories,0) + ?
                WHERE date = ? ");
        $sql->execute(array($calsToAdd,$this->date));
    }
    function nullCals() {
        $sql = $this->db->prepare(
            "UPDATE $this->table
                SET calories = NULL
                WHERE date = ? ");
        $sql->execute(array($this->date));
    }
    function addExercise($exToAdd) {
        $sql = $this->db->prepare(
            "UPDATE $this->table
                SET exercise = IFNULL(exercise,0) + ?
                WHERE date = ? ");
        $sql->execute(array($exToAdd,$this->date));
    }
    function addNotes($notesToAdd) {
        $sql = $this->db->prepare(
            'UPDATE ' . $this->table . '
                SET notes =
                  CONCAT(
                      notes,
                      if(notes="","","\n"),
                      ? )
                WHERE date = ? ' );
        $sql->execute(array($notesToAdd,$this->date));
    }
    function replaceNotes($replaceNotes) {
        $sql = $this->db->prepare(
            "UPDATE $this->table
                SET notes = ?
                WHERE date = ? " );
        $sql->execute(array($replaceNotes,$this->date));
    }
    function addTemp($tempToAdd) {
        $sql = $this->db->prepare(
            'UPDATE ' . $this->table . '
                SET temp =
                    CONCAT(
                        temp,
                        if(temp="","","\n"),
                        ? )
                WHERE date = ? ');
        $sql->execute(array($tempToAdd,$this->date));
    }
    function replaceTemp($replaceTemp) {
        $sql = $this->db->prepare(
            "UPDATE $this->table
                SET temp = ?
                WHERE date = ? ");
        $sql->execute(array($replaceTemp,$this->date));
    }


    // select row and return associative array
    function selectRowByDate() {
        $sql = $this->db->prepare(
            "SELECT
                date,
                IFNULL(calories,0) as calories,
                IFNULL(exercise,0) as exercise,
                notes,
                temp
            FROM $this->table
            WHERE date=?");
        $sql->execute(array($this->date)); // returnFailure("Query couldn't run");
        if ($sql->rowCount()==0) return NULL;
        return $sql->fetch(PDO::FETCH_ASSOC);
    }


    // clean up temporary stuff from over a week ago
    function cleanTemp() {
        $sql = $this->db->prepare(
            "UPDATE  $this->table
                SET temp = ''
                WHERE date < DATE_SUB(CURDATE(),INTERVAL 1 WEEK)
                ");
        $sql->execute();
    }

    // insert row for new date
    function insertDateRow() {
        $sql = $this->db->prepare(
            'INSERT INTO
                ' . $this->table . ' (date,notes,temp)
                VALUES (?,"","")');
        $sql->execute(array($this->date));
        return $sql->rowCount()>0;
    }

}

?>
