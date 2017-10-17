<?php
require_once("Model.php");

class UserModel extends Model {

    // inherit $db, $userTable, $logTable

    public function __construct() {
        parent::__construct();  // creates db connection, sets $userTable
    }

    // is email already in userTable?
    private function isEmailTaken($email) {
        try {    
            $sql = $this->db->prepare(
                "SELECT 1
                    FROM " . $this->userTable . "
                    WHERE email = ?
                    LIMIT 1 ");
            $sql->execute(array($email)); 
        } catch (Exception $e) {
            throw $e;
        }
        return ($sql->rowCount()>0);
    }

    // add user for email/pw combination
    // if email is already there, throw exception
    public function addUserAndGetUserID($email,$pw) {
        try {
            if ($this->isEmailTaken($email)) 
                throw new RuntimeException("Email already has an account");
            $sql = $this->db->prepare(
                'INSERT INTO ' . $this->userTable . 
                    '(email,pw) VALUES (?,sha2(?,256))' );
            $sql->execute(array($email,$pw));
        } catch (RuntimeException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new RuntimeException('Server error.');
        }
        if ($sql->rowCount()<1) throw new RuntimeException('User could not be created.');
        return $this->db->lastInsertId();
    }

    // check $userTable for email/pw combination, return person_id
    // if not in table, throw exception
    public function getUserID($email,$pw) {
        $sql = '';
        $result = array('person_id' => null);
        try {
            $sql = $this->db->prepare(
                "SELECT person_id
                    FROM " . $this->userTable . "
                    WHERE email = ?
                        AND pw = sha2(?,256) ");
            $sql->execute(array($email,$pw));
            $result = $sql->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new RuntimeException('Server error');
        }
        if ($sql->rowCount()<1) throw new RuntimeException('Wrong username or password');
        return $result['person_id'];
    }
}

?>
