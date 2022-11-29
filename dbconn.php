<?php
    session_start();
    require('operations.php');
    class dbconfig {
        public $connection;
        public function __construct() {
            $this->db_connect();
        }

        public function db_connect() {
            $this->connection = mysqli_connect("localhost", "root", "", "test");
            echo "Connection successful.";
            if (mysqli_connect_error()) {
                echo "Connected unsuccessfully";
                die("Connection failed: " . mysqli_connect_error());
            }
        }

        public function check($string) {
            $return = mysqli_real_escape_string($this->connection, $string);
            return $return;
        }
    }
?>