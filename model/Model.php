<?php
require_once("Config.php");

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
        $regex = "/^[a-zA-Z0-9\$_]+$/";
        if(!preg_match($regex,Config::$userTable) || !preg_match($regex,Config::$logTable))
            throw new RuntimeException('Bad table name(s)');
        $this->userTable = Config::$userTable;
        $this->logTable = Config::$logTable;
    }

}

?>