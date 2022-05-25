<?php
// Author: Anh Tuan Doan
// Description: Logout page
if(!isset($_SESSION)) session_start(); 
if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == true) {
    $_SESSION = array(); // empty the SESSION variables
    session_destroy(); // destroy the SESSION
    header("Location: login.php"); // return to the login page
} else {
    header("Location: login.php"); // return to the login page
}
?>