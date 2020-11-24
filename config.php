<?php
class config {
    // public $servername;
    // public $username;
    // public $password;
    // public $dbname;
    public $conn;
    function __construct() {
        $this->conn = mysqli_connect('localhost', 'root', '', 'cabbooking');
        if(!$this->conn) {
            die("Connection failed ".$conn->connect_error);
        }
    }
}
?>