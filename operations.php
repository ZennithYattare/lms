<?php
    require_once('dbconn.php');
    $db = new dbconfig();

    class operations extends dbconfig {
        public function registerUser()
        {
            global $db;
            if(isset($_POST['signup']))
            {	
                
                $name = $db->check($_POST['Name']);
                $email = $db->check($_POST['Email']);
                $password = $db->check($_POST['Password']);
                $mobno = $db->check($_POST['PhoneNumber']);
                $rollno = $db->check($_POST['RollNo']);
                $category = $db->check($_POST['Category']);
                $type = 'Student';

                if ($this->insertUserData($name, $email, $password, $mobno, $rollno,$category, $type)) {
                    echo "<script type='text/javascript'>alert('Registration Successful')</script>";
                } else {
                    //echo "Error: " . $sql . "<br>" . $conn->error;
                    echo "<script type='text/javascript'>alert('Failed Registration')</script>";
                }
            }
        }

        function insertUserData($insName, $insEmail, $insPassword, $insMobNo, $insRollNo, $insCategory, $insType) {
            global $db;
            $sql = "insert into user (Name,Type,Category,RollNo,EmailId,MobNo,Password) values('$insName','$insType','$insCategory','$insRollNo','$insEmail','$insMobNo','$insPassword')";
            $result = mysqli_query($db->connection, $sql);

            if ($result) {
                return true;
            } else {
                return false;
            }
        }

        public function loginUser() {
            global $db;

            if(isset($_POST['signin'])) {
                
                if (!empty($_POST['RollNo']) && !empty($_POST['Password'])){
                    $u = $db->check($_POST['RollNo']);
                    $p = $db->check($_POST['Password']);
                    // Missing Category input for login? Login will break if left unavailable. Will comment out until input is available.
                    // $c = $db->check($_POST['Category']);
                    
                    // Removed $c = Category until above is satisfied.
                    if ($this->getUserData($u, $p)) {
                        echo "<script type='text/javascript'>alert('Logging in')</script>";
                    }
                } else {
                    echo "<script type='text/javascript'>alert('One of the inputs is blank.')</script>";
                }     
            }
        }

        function getUserData($insRollNo, $insPassword) {
            global $db;
            $sql = "select * from user where RollNo='$insRollNo'";
            $result = mysqli_query($db->connection, $sql);
            $row = $result->fetch_assoc();
            // Checks if row exists in the table/database, if not, it will throw the error of incorrect rollno or password.
            if ($row) {
                $x = $row['Password'];
                $y = $row['Type'];
                if(strcasecmp($x, $insPassword) == 0 && !empty($insRollNo) && !empty($insPassword))
                {
                    //echo "Login Successful";
                    $_SESSION['RollNo'] = $insRollNo;
                
                    if($y == 'Admin'){
                        header('location:admin/index.php');
                    }
                    else {
                        header('location:student/index.php');   
                    }
                } 
            } else { 
                echo "<script type='text/javascript'>alert('Failed to Login! Incorrect RollNo or Password')</script>";
            }
        }
        
    }         
?>