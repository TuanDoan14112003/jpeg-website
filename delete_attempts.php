<!-- 
filename: delete_attempts.php
author: Anh Tuan Doan
created: 10/5/2022
last modified: 29/5/2022
description: delete all attempts of a student
-->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="manage JPEG database">
    <meta name="keywords" content="JPEG">
    <meta name="author" content="Anh Tuan Doan">
    <title>Delete attempts</title>
	<link rel="stylesheet" href="styles/style.css">
</head>
<body>
    
<?php
    $page = 'delete-attempts';
    include_once("header.inc") // include the header element
?>
<section class='main-content manage-content'>
    <h2>Delete attempts</h2>
<?php
    include_once('sanitise_input.php');
    require_once('database_credentials.php'); // database information (host, username, password)
    if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
        $errMsg = '';
        if (isset($_POST['student_id'])) {
            $student_id = $_POST['student_id'];
            $student_id = sanitise_input($student_id); // sanitise input to prevent SQL injection
            if ($student_id == "") {
                $errMsg .= "<p class='error'>You must enter the student id</p>";
            } else if (!preg_match('/^(\d{7}|\d{10})$/',$student_id)) { // check if the student id is either 7 or 10 digits numbers
                $errMsg .= "<p class='error'>The student ID must be either 7 or 10 digits number</p>";
            }
        }

        if ($errMsg == '') {
            $connection = mysqli_connect($host,$user,$pwd,$sql_db); // connect to the database
            if ($connection) {
                $find_attempt_query = "SELECT * FROM attempts WHERE student_id=$student_id"; // find the attempts with the student id
                $find_attempt_query_result = mysqli_query($connection,$find_attempt_query);
                $count = mysqli_num_rows($find_attempt_query_result);
                if ($count == 0) { // return an error message if there aren't any row with the specified details
                    echo "<p class='error'>There's no attempt with the student id {$student_id}</p>";
                } else {
                    $delete_attempts_query = "DELETE FROM attempts WHERE student_id=$student_id"; // delete all attempts of a student
                    $delete_attempts_query_result = mysqli_query($connection,$delete_attempts_query);
                    if ($delete_attempts_query_result) {
                        if(!isset($_SESSION)) session_start(); 
                        $_SESSION['successful_message'] = "Deleted all attempts for student {$student_id}"; // Add a successful message to the manage.php page 
                        header("location: manage.php"); // return to the manage.php page
                        
                    } else {
                        echo "<p class='error'>Can't query: {$delete_attempts_query_result}</p>";
                    }
                }
            } else {
                echo "<p class='error'>Can't connect to the database</p>";
            }
            
            
        } else {
            echo $errMsg;
        }
        echo "<a href='manage.php'>Go back to the manage page</a>";
    } else {
        echo "<a href='manage.php'>Go back to the manage page</a>";
    }
?>
</section>
<?php
    include_once("footer.inc"); // include the footer element
?>

</body>
</html>