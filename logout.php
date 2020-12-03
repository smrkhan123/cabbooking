<?php
session_start();
if($_SESSION['usertype'] == '0' ) {
    unset($_SESSION['booking']);
    unset($_SESSION['username']);
    unset($_SESSION['usertype']);
    unset($_SESSION['id']);
} elseif($_SESSION['usertype'] == '1') {
    unset($_SESSION['username']);
    unset($_SESSION['usertype']);
    unset($_SESSION['id']);
}
header("location: index.php");
?>