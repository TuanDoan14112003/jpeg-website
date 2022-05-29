<?php
/*
filename: logout.php
author: Anh Tuan Doan
created: 10/5/2022  
last modified: 29/5/2022
description: logout page
*/
if(!isset($_SESSION)) session_start(); 
if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == true) {
    $_SESSION = array(); // empty the SESSION variables
    session_destroy(); // destroy the SESSION
    header("Location: login.php"); // return to the login page
} else {
    header("Location: login.php"); // return to the login page
}
?>