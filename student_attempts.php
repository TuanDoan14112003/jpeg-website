<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="manage JPEG database">
    <meta name="keywords" content="JPEG">
    <meta name="author" content="Anh Tuan Doan">
    <title>Attemmpts</title>
	<link rel="stylesheet" href="styles/style.css">
</head>
<body>
    
<?php
    $page = 'student-attempts';
    include_once("header.inc")
?>
<section class='main-content manage-content'>
    <h2>All the attempts for a student</h2>
<?php

    include_once("display_table.php");
    include_once('sanitise_input.php');
    require_once('database_credentials.php');
    if ($_SERVER['REQUEST_METHOD'] == 'GET')  {
        $errMsg = '';
        if (isset($_GET['query_method'])) {
            $query_method = $_GET['query_method'];
            $query_method = sanitise_input($query_method);
            if ($query_method == "") {
                $errMsg .= "<p class='error'>You must specify the query method (using name or student id)</p>";
            } 
        }
        if (isset($_GET['query_value'])) {
            $query_value = $_GET['query_value'];
            $query_value = sanitise_input($query_value);
            if ($query_value == "") {
                $errMsg .= "<p class='error'>You must specify the query value (using name or student id)</p>";
            } elseif (isset($query_method) and $query_method == 'student_id' and !preg_match('/^(\d{7}|\d{10})$/',$query_value)) {
                $errMsg .= "<p class='error'>The student id must be either 7 or 10 digits number</p>";
            } elseif (isset($query_method) and $query_method == 'first_name' and !preg_match('/^[a-zA-Z- ]{1,30}$/',$query_value)) {
                $errMsg .= "<p class='error'>Name must be max 30 alpha|space|hyphen characters</p>";
            }
        }
        if ($errMsg == '') {
            $connection = mysqli_connect($host,$user,$pwd,$sql_db);
            if ($connection) {
                $find_attempt_query = "SELECT * FROM attempts WHERE {$query_method}='{$query_value}'";
                $find_attempt_query_result = mysqli_query($connection,$find_attempt_query);
                $count = mysqli_num_rows($find_attempt_query_result);
                if ($count == 0) {
                    echo "<p class='error'>There's no attempt with the specified details</p>";
                } else {
                    $student_attempts_query = "SELECT * FROM attempts WHERE {$query_method}='{$query_value}'";
                    $student_attempts_query_result = mysqli_query($connection,$student_attempts_query);
                    if ($student_attempts_query_result) {
                        // echo "<p>Deleted all attempt for student {$student_id}</p>";
                        displaY_table($student_attempts_query_result);
                        mysqli_free_result($student_attempts_query_result);
                    } else {
                        echo "<p class='error'>Can't query: {$student_attempts_query_result}</p>";
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