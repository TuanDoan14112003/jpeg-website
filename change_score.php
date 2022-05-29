<!-- 
filename: change_score.php
author: Anh Tuan Doan
created: 10/5/2022
last modified: 29/5/2022
description: change score for an attempt
-->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="manage JPEG database">
    <meta name="keywords" content="JPEG">
    <meta name="author" content="Anh Tuan Doan">
    <title>Change score</title>
	<link rel="stylesheet" href="styles/style.css">
</head>
<body>
    
<?php
    $page = 'change-score';
    include_once("header.inc") // include header element
?>
<section class = 'main-content manage-content'>
    <h2>Change score</h2>
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
            } else if (!preg_match('/^(\d{7}|\d{10})$/',$student_id)) { // check if the student id contains either 7 or 10 digits.
                $errMsg .= "<p class='error'>The student ID must be either 7 or 10 digits numbers</p>";
            }
        }
        if (isset($_POST['attempt'])) {
            $attempt = $_POST['attempt'];
            $attempt = sanitise_input($attempt); // sanitise input to prevent SQL injection
            if ($attempt == "") {
                $errMsg .= "<p class='error'>You must enter the attempt</p>";
            } else if (!is_numeric($attempt)) {
                $errMsg .= "<p class='error'>The attempt must be a number</p>";
            } else if ($attempt > 2 or $attempt < 1) {
                $errMsg .= "<p class='error'>The attempt must be either 1 or 2</p>";
            }
        }
        if (isset($_POST['new_score'])) {
            $new_score = $_POST['new_score'];
            $new_score = sanitise_input($new_score); // sanitise input to prevent SQL injection
            if ($new_score == "") {
                $errMsg .= "<p class='error'>You must enter the new score</p>";
            } else if (!is_numeric($new_score)) {
                $errMsg .= "<p class='error'>The new score must be a number</p>";
            } else if ($new_score > 100 or $new_score < 0) {
                $errMsg .= "<p class='error'>The new score must be in between 0 and 100</p>";
            }
        }
        if ($errMsg == '') {
            $connection = mysqli_connect($host,$user,$pwd,$sql_db); // connect to the database
            if ($connection) {
                $find_attempt_query = "SELECT * FROM attempts WHERE student_id=$student_id AND number_of_attempts=$attempt"; // find the correct attempt
                $find_attempt_query_result = mysqli_query($connection,$find_attempt_query);
                $count = mysqli_num_rows($find_attempt_query_result); // count the number of rows of the result
                if ($count != 1) { // return an error message if there aren't any rows
                    echo "<p class='error'>There's no attempt with the student id {$student_id} and attempt {$attempt}</p>";
                } else {
                    $update_score_query = "UPDATE attempts SET score=$new_score WHERE student_id=$student_id AND number_of_attempts=$attempt"; // update the row with the new score
                    $update_score_query_result = mysqli_query($connection,$update_score_query);
                    if ($update_score_query_result) {
                        if(!isset($_SESSION)) session_start(); 
                        $_SESSION['successful_message'] = "Updated score for student {$student_id}"; // Add a successful message to the manage.php page
                        header('Location: manage.php'); // return to the manage.php page
                    } else {
                        echo "<p class='error'>Can't query: {$update_score_query}</p>";
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