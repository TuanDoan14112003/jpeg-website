<?php
if(!isset($_SESSION)) session_start(); 
if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == true) {
    $_SESSION = array();
    session_destroy();
    header("Location: login.php");
} else {
    header("Location: login.php");
}
?>