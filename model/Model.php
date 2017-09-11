<?php
require_once("./../Config.php");

class Model {
    protected $db;
    protected $userTable;
    protected $logTable;

    public function __construct() {
        $this->db = new PDO(
            "mysql:host=" . Config::$hostname . 
                ";dbname=" . Config::$database,
            Config::$username,
            Config::$pw
        );
        $this->userTable = Config::$userTable;
        $this->logTable = Config::$logTable;
    }
}

?>