<?php

$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$database="lms";
// Create connection
$conn = mysqli_connect($dbservername, $dbusername, $dbpassword,$database) or die("Couldn't connect to database");
// Check connection

$id=0;

//DELETE RECORDS
if (isset($_GET['delete'])){
    $id = $_GET['delete'];

    $conn->query("DELETE FROM user WHERE RollNo=$id") or die("Couldn't connect to database");
    
 

    
    header("Location: student.php");
 
}





?>