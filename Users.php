<?php
session_start();
// session_destroy();
include('config.php');
// $obj = new config();
class Users {
    public $username;
    public $name;
    public $password;
    public $mobile;
    public $isblock;
    public $isadmin;

    function signup($username, $name, $phone, $role, $pass, $isblock, $conn) {
        $qry = "INSERT INTO `users` (`user_name`, `name`, `dateofsignup`, `mobile`, `isblock`, `password`, `isadmin`) VALUES ('".$username."', '".$name."', NOW(), '".$phone."', '".$isblock."', '".$pass."', '".$role."')";
        $run = mysqli_query($conn, $qry);
        if ($run == true) {
            if($isblock == "1") {
                header("location:login.php");
            } else {
                echo "<script>alert('You are successfully registered! Please wait for admin appeovel.');</script>";
            }
        } else {
            die("Some errror Occured". mysqli_error($conn));
        }
    }

    function login($username, $password, $conn){
        $qry = "SELECT * FROM users WHERE `user_name` = '$username' AND `password` = '$password'";
        $run = mysqli_query($conn, $qry);
        $row = mysqli_num_rows($run);
        if ($row<1) {
            $error = 'Please enter a valid Username or Password';
        } else {
			$data = mysqli_fetch_assoc($run);
            if($data['isblock']== "0" ){
                echo "<script>alert('You are successfully registered! Please wait for admin approvel.');</script>";
            } else {
				$id = $data['user_id'];
                $usertype = $data['isadmin'];
                $_SESSION['id'] = $id;
				$_SESSION['usertype'] = $usertype;
				if($usertype == "1"){
					header("location:admindashboard.php");
				} else {
					header("location:index.php");
				}
            }
        }
    }

    function logout(){
        session_destroy();
        header("location: index.php");
    }

    function select_users($isadmin, $conn) {
        $sql = "SELECT * FROM `users` WHERE isadmin = '".$isadmin."'";
        $run = mysqli_query($conn, $sql);
        $rows = mysqli_num_rows($run);
        if($rows>0) {
            return $run;
        }
    }

    function block($id, $conn) {
        $isblck = "";
        $qry = "SELECT * FROM users WHERE `user_id` = $id";
        $run = mysqli_query($conn, $qry);
        if(mysqli_num_rows($run)>0){
            $data = mysqli_fetch_assoc($run);
            if($data['isblock']=="0"){
                $isblck = "1";
            } else {
                $isblck = "0";
            }
            $final = "UPDATE `users` SET `isblock` = $isblck WHERE `user_id` = $id";
            $runqry = mysqli_query($conn, $final);
            if(!$runqry){
                echo "Some error occured!".mysqli_error($conn);
            }
        }
    }
}

?>