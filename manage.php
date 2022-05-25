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
    $page = 'manage';
    include_once("header.inc") // include the header element
?>
<section class='main-content manage-content'>
    <h2>Quiz supervisor</h2>
    <?php
    if(!isset($_SESSION)) session_start(); 

    if (isset($_SESSION['successful_message'])) {
        echo "<p class='successful-message'>{$_SESSION['successful_message']}</p>";
    }
    
    ?>
<?php
require_once "database_credentials.php";
include_once "display_table.php";
if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == true){
    if (isset($_SESSION['is_an_admin']) and $_SESSION['is_an_admin'] == 1) {
        $connection = mysqli_connect($host,$user,$pwd,$sql_db);
        if ($connection) {
            // create 'attempts' table if it does not already exists
            $create_table_if_not_exists_query = "CREATE TABLE if not exists attempts ( attempt_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
                                                                                       time DATETIME NOT NULL , 
                                                                                       first_name VARCHAR(30) NOT NULL , 
                                                                                       last_name VARCHAR(30) NOT NULL , 
                                                                                       student_id VARCHAR(10) NOT NULL, 
                                                                                       number_of_attempts TINYINT NOT NULL, 
                                                                                       score TINYINT NOT NULL, 
                                                                                       user_id INT NOT NULL, 
                                                                                       FOREIGN KEY (user_id) REFERENCES users(user_id));";
            $create_table_if_not_exists_query_result = mysqli_query($connection,$create_table_if_not_exists_query);
            if ($create_table_if_not_exists_query_result) {
                // List all the attempts
                $query1 = "SELECT * FROM attempts"; // get every attempts
                $result1 = mysqli_query ($connection, $query1);
                if($result1) {
                    echo "<h3>All attempts:</h3>";
                    display_table($result1);
                    mysqli_free_result($result1); // free the result.
                } else {
                    echo "<p class='error'>can't query</p>";
                }

                // Find attempts of a student
                echo "<h3>List all attempts for a student</h3>";
                echo "<form method='GET' action='student_attempts.php'>";
                echo "<p class='questions'>
                        <label for='query_method'>List the attempts for a student with their ID or name:</label>
                        <select class='selection' name='query_method' id='query_method'>
                            <option value=''>Please select an option</option>
                            <option value='student_id'>Student id</option>
                            <option value='first_name'>Name</option>
                        </select>
                        <label for='query_value'>Value:</label>
                        <input type='text' name='query_value' id ='query_value' placeholder='Please enter the student id or the student name'><br> 
                    </p>";
                echo "<button class='btn btn1' type='submit'>List the attempts</button>";
                echo "</form>";

                // List students who got 100% on their first attempt. 
                $query3 = "SELECT student_id,first_name,last_name FROM attempts WHERE number_of_attempts=1 AND score=100";
                $result3 = mysqli_query ($connection, $query3);
                if($result3) {
                    echo "<h3>All students who got 100% on their first attempt. </h3>";
                    display_table($result3);
                    mysqli_free_result($result3);
                } else {
                    echo "can't query";
                }

                // List students who got less than 50% on their second attempt.
                $query4 = "SELECT student_id,first_name,last_name FROM attempts WHERE number_of_attempts=2 AND score<50";
                $result4 = mysqli_query ($connection, $query4);
                if($result4) {
                    echo "<h3>All students got less than 50% on their second attempt. </h3>";
                    display_table($result4);
                    mysqli_free_result($result4);
                } else {
                    echo "can't query";
                }
            
                // Delete all attempts for a student
                echo "<h3>Delete all attempts for a student</h3>";
                echo "<form method='POST' action='delete_attempts.php'>";
                echo "<label for='delete_attempts_student_id'>Student id:</label>";
                echo "<input type='text' name='student_id' id ='delete_attempts_student_id'><br> ";
                echo "<button class='btn btn1' type='submit'>Delete the attempts</button>";
                echo "</form>";

                // Change an attempt's score.
                echo "<h3>Change the score for an attempt</h3>";
                echo "<form method='POST' action='change_score.php'>";
                echo "<label for='change_score_student_id'>Student id:</label>";
                echo "<input type='text' name='student_id' id ='change_score_student_id'><br> ";
                echo "<label for='attempt'>Attempt:</label>";
                echo "<input type='text' name='attempt' id ='attempt'><br>";
                echo "<label for='new_score'>New score:</label>";
                echo "<input type='text' name='new_score' id ='new_score'><br>";
                echo "<button class='btn btn1' type='submit'>Change the score</button>";
                echo "</form>";
                
            } else {
                echo "<p class='error'>Can't create attempt table</p>";
            }
            mysqli_close($connection);
        } else {
            echo "<p class='error'>Can't connect to the database</p>";
        }
    } else {
        echo "<p class='error'>You're not allowed to view this page</p>";
    }
} else {
    echo "<p class='error'>You must <a href='login.php'>login</a> to view this page</p>";
}

?>
</section>
<?php
include_once("footer.inc"); // include the footer element
unset($_SESSION['successful_message']);
?>
</body>
</html>