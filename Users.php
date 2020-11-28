<?php
session_start();
include('config.php');
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

    function login($username, $password, $type, $remember, $conn){
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
                if($remember != "") {
                    setcookie("member", $username, time()+10*365*24*60*60);
                    setcookie("password", $password, time()+10*365*24*60*60);
                } else {
                    if(isset($_COOKIE['member'])){
                        setcookie("member", "");
                        setcookie("password","");
                    }
                }
                $id = $data['user_id'];
                $usertype = $data['isadmin'];
                $uname = $data['user_name'];
                $_SESSION['id'] = $id;
                $_SESSION['usertype'] = $usertype;
                $_SESSION['username'] = $uname;
				if($usertype == "1"){
					header("location:admin/admindashboard.php");
				} else {
					if(count($type)>0) {
                        $from = $type[0];
                        $to = $type[1];
                        $luggage = $type[2];
                        $distance = $type[3];
                        $fare = $type[4];
                        header("location:confirmbooking.php?booking=1&from=$from&to=$to&luggage=$luggage&fare=$fare&distance=$distance");
            
                    } else {
                        header("location:index.php");
                    } 
				}
            }
        }
    }

    function select_users($isadmin, $conn) {
        $sql = "SELECT * FROM `users` WHERE isadmin = '".$isadmin."'";
        $run = mysqli_query($conn, $sql);
        $rows = mysqli_num_rows($run);
        if($rows>0) {
            return $run;
        }
    }

    function select_pending_users($status, $conn) {
        $sql = "SELECT * FROM `users` WHERE `isblock` = $status AND `isadmin` = 0";
        $run = mysqli_query($conn, $sql);
        $rows = mysqli_num_rows($run);
        if($rows>0) {
            return $run;
        }
    }

    function select_user_id($id, $conn){
        $sql = "SELECT * FROM `users` WHERE `user_id` = '".$id."'";
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

    function update($id, $username, $name, $phone, $role, $pass, $isblock, $conn) {
        $qry = "UPDATE users SET `user_name` = '".$username."', `name` = '".$name."', `dateofsignup` = NOW(), `mobile` = '".$phone."', `isblock` = '".$isblock."', `password` = '".$pass."', `isadmin` = '".$role."' WHERE `user_id` = '".$id."'";
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

    function sort_users($sort, $order, $conn) {
        if($sort == "mobile"){
            $sort = "cast(`$sort` AS unsigned)";
        }
        $sql = "SELECT * FROM `users` WHERE isadmin = '0' ORDER BY $sort $order";
        $runqry = mysqli_query($conn, $sql);
        if(!$runqry){
            return '0';
        } else {
            return $runqry;
        }
    }
    function sort_pending_users($sort, $order, $status, $conn) {
        if($sort == "mobile"){
            $sort = "cast(`$sort` AS unsigned)";
        }
        $sql = "SELECT * FROM `users` WHERE `isadmin` = '0' AND `isblock` = $status ORDER BY $sort $order";
        // return $sql;
        $runqry = mysqli_query($conn, $sql);
        if(!$runqry){
            return '0';
        } else {
            return $runqry;
        }
    }

    function update_password($id, $username, $name, $phone, $isblock, $pass, $role, $conn) {
        $sql = "UPDATE users SET `user_name` = '".$username."', `name` = '".$name."', `dateofsignup` = NOW(), `mobile` = '".$phone."', `isblock` = '".$isblock."', `password` = '".$pass."', `isadmin` = '".$role."' WHERE `user_id` = '".$id."'";
        $runqry = mysqli_query($conn, $sql);
        if(!$runqry){
            return '0';
        } else {
            return $runqry;
        }
    }
}

?>