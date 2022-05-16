<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="manage JPEG database">
    <meta name="keywords" content="JPEG">
    <meta name="author" content="Anh Tuan Doan">
    <title>Manage</title>
	<link rel="stylesheet" href="styles/style.css">
</head>
<body>
    
<?php
    $page = 'delete-attempts';
    include_once("header.inc")
?>
<section class='main-content manage-content'>
    <h2>Delete attempts</h2>
<?php
    include_once('sanitise_input.php');
    require_once('database_credentials.php');
    if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
        $errMsg = '';
        if (isset($_POST['student_id'])) {
            $student_id = $_POST['student_id'];
            $student_id = sanitise_input($student_id);
            if ($student_id == "") {
                $errMsg .= "<p class='error'>You must enter the student id</p>";
            } else if (!preg_match('/^(\d{7}|\d{10})$/',$student_id)) {
                $errMsg .= "<p class='error'>The student ID must be either 7 or 10 digits numbers</p>";
            }
        }

        if ($errMsg == '') {
            $connection = mysqli_connect($host,$user,$pwd,$sql_db);
            if ($connection) {
                $find_attempt_query = "SELECT * FROM attempts WHERE student_id=$student_id";
                $find_attempt_query_result = mysqli_query($connection,$find_attempt_query);
                $count = mysqli_num_rows($find_attempt_query_result);
                if ($count == 0) {
                    echo "<p class='error'>There's no attempt with the student id {$student_id}</p>";
                } else {
                    $delete_attempts_query = "DELETE FROM attempts WHERE student_id=$student_id";
                    $delete_attempts_query_result = mysqli_query($connection,$delete_attempts_query);
                    if ($delete_attempts_query_result) {
                        if(!isset($_SESSION)) session_start(); 
                        $_SESSION['successful_message'] = "Deleted all attempts for student {$student_id}";
                        header("location: manage.php");
                        
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
    include_once("footer.inc");
?>

</body>
</html>