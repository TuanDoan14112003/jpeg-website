<!-- 
filename: markquiz.php
authors: Anh Tuan Doan
created: 15/5/2022
last modified: 29/5/2022
description: Mark quiz page
-->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="JPEG mark quiz page">
    <meta name="keywords" content="JPEG">
    <meta name="author" content="Anh Tuan Doan">
    <title>JPEG Quizzes result</title>
	<link rel="stylesheet" href="styles/style.css">
</head>
<body>
<?php
	
	$page = 'mark-quiz';
	include_once("header.inc"); // include the header element
    if(!isset($_SESSION)) session_start();
?>
    <section class="mark-quiz-content main-content">
        <h2>JPEG Quiz Result</h2>
        <?php
            if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == true) {
                include_once('display_table.php');
                include_once("sanitise_input.php");
                date_default_timezone_set('Australia/Melbourne');
                if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['student_id'])) {
                    require_once "database_credentials.php";
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
                            $errMsg = "";
                            if (isset($_POST['first_name'])) {
                                $first_name = $_POST['first_name'];
                                $first_name = sanitise_input($first_name); // sanitise input to prevent SQL injection
                                if ($first_name == "") {
                                    $errMsg .= "<p class='error'>You must enter your first name.</p>";
                                } else if (!preg_match('/^[a-zA-Z- ]{1,30}$/',$first_name)) { // check if first name have less than 30 characters and only contain letters, spaces, or hyphens.
                                    $errMsg .= "<p class='error'>First name must have less than 30 characters and only contain letters, spaces, or hyphens.</p>";
                                }
                            }
                            if (isset($_POST['last_name'])) {
                                $last_name = $_POST['last_name'];
                                $last_name = sanitise_input($last_name); // sanitise input to prevent SQL injection
                                if ($last_name == "") {
                                    $errMsg .= "<p class='error'>You must enter your last name.</p>";
                                } else if (!preg_match('/^[a-zA-Z- ]{1,30}$/',$last_name)) {  // check if last name have less than 30 characters and only contain letters, spaces, or hyphens.
                                    $errMsg .= "<p class='error'>Last name must have less than 30 characters and only contain letters, spaces, or hyphens.</p>";
                                }
                            }
                            if (isset($_POST['student_id'])) {
                                $student_id = $_POST['student_id'];
                                $student_id = sanitise_input($student_id); // sanitise input to prevent SQL injection
                                if ($student_id == "") {
                                    $errMsg .= "<p class='error'>You must enter your student id</p>";
                                } else if (!preg_match('/^(\d{7}|\d{10})$/',$student_id)) { //check if the student id is either 7 or 10 digits number
                                    $errMsg .= "<p class='error'>The student ID must be either 7 or 10 digits number</p>";
                                }
                            }
                            if (isset($_POST['question_list'])) {
                                $question_list = explode(",",$_POST['question_list']); //convert the questions_list string to an array
                                foreach ($question_list as $question_id) {

                                    // Check if all questions are answered
                                    if (isset($_POST["question_{$question_id}"])) { 
                                        $answer = $_POST["question_{$question_id}"];
                                        if ($answer == "") {
                                            $errMsg .= "<p class='error'>You have to answer all questions.</p>";
                                            break;
                                        }
                                    } else {
                                        $errMsg .= "<p class='error'>You have to answer all questions.</p>";
                                        break;
                                    }
                                }
                            }
                            if ($errMsg == "") {
                                $current_date = date('Y-m-d H:i:s'); // get the current date
                                $attempt_query = "SELECT * FROM attempts WHERE student_id='{$student_id}'";
                                $attempt_query_result = mysqli_query($connection,$attempt_query);
                                if ($attempt_query_result) {
                                    $attempt = mysqli_num_rows($attempt_query_result) + 1;
                                
                                    if ($attempt < 3) { // Check if the attempt number is less than 3, if not return an error message
                                        if (isset($_POST['question_list'])) {
                                            $question_list = explode(",",$_POST['question_list']);
                                            $question_count = 0;
                                            $total_correct_answer = 0;
                                            echo "<section class='student-info'>";
                                            echo "<p>Student first name: <em><strong>{$first_name}</strong></em></p>";
                                            echo "<p>Student last name: <em><strong>{$last_name}</strong></em></p>";
                                            echo "<p> Student id: <em><strong>{$student_id}</strong></em></p>";
                                            echo "<p> Attempt: <em><strong>{$attempt}</strong></em></p>";
                                            echo "</section>";
                                            foreach ($question_list as $question_id) {
                                                $question_count += 1;
                                                
                                                $get_answer_query = "SELECT * FROM questions WHERE question_id={$question_id}"; // get the question from the database
                                            
                                                $query_result = mysqli_query($connection,$get_answer_query);
                                                if ($query_result) {
                                            
                                                    $row = mysqli_fetch_assoc($query_result);
                                                    if (isset($_POST["question_{$question_id}"])) {
                                                        
                                                        if ($row['question_type'] == 'check-boxes') {
                                                            $correct_answers = json_decode($row['correct_answer']);
                                                            $user_answers = $_POST["question_{$question_id}"];
                                                            sort($correct_answers);
                                                            sort($user_answers);
                                                            echo "<p class='question'>Q) {$row['question']}</p>";
                                                            if ($correct_answers === $user_answers) { // check if the answers are correct
                                                                $total_correct_answer += 1;
                                                                echo "<p class='answers'>Your answers are: ";
                                                                for($index = 0; $index < count($user_answers);$index++) {
                                                                    if ($index != 0) echo ", ";
                                                                    echo "<em><strong>{$user_answers[$index]}</strong></em>";
                                                                }
                                                                echo "<img class='answer-icons' src='images/check.png' alt='green tick'/>";
                                                                echo "</p>";
                                                            } else {
                                                                echo "<p class='answers'>Your answers are: ";
                                                                for($index = 0; $index < count($user_answers);$index++) {
                                                                    if ($index != 0) echo ", ";
                                                                    echo "<em><strong>{$user_answers[$index]}</strong></em>";
                                                                }
                                                                echo "<img class='answer-icons' src='images/cross.png' alt='red cross'/>";
                                                                echo "</p>";
                                                                echo "<p class='answers'>The correct answers are: ";
                                                                for($index = 0; $index < count($correct_answers);$index++) {
                                                                    if ($index != 0) echo ", ";
                                                                    echo "<em><strong>{$correct_answers[$index]}</strong></em>";
                                                                }
                                                                
                                                                echo "</p>";
                                                            }
                                                            
                                                        }
                                                        else {
                                                            $correct_answer =$row['correct_answer'];
                                                            $user_answer = sanitise_input($_POST["question_{$question_id}"]);
                                                            echo "<p class='question'>Q) {$row['question']}</p>";
                                                        
                                                            if (trim(strtolower($correct_answer)) == strtolower($user_answer)) { // check if the answers are correct
                                                            
                                                                $total_correct_answer += 1;
                                                                echo "<p class='answers'>Your answer: <em><strong>{$user_answer}</strong></em>";
                                                                echo "<img class='answer-icons' src='images/check.png' alt='green tick'/>";
                                                                echo "</p>";
                                                            } else {
                                                            
                                                                echo "<p class='answers'>Your answer: <em><strong>{$user_answer}</strong></em>";
                                                                echo "<img class='answer-icons' src='images/cross.png' alt='red cross'/>";
                                                                echo "</p>";
                                                                echo "<p class='answers'>The correct answer is: <em><strong>{$correct_answer}</strong></em></p>";
                                                            }
                                                        }
                                                    
                                                    }
                                                    mysqli_free_result($query_result); // free the pointer
                                                } else {
                                                    echo "<p class='error'>can't query</p>";
                                                }
                                            }
                                            $final_score = number_format($total_correct_answer / $question_count * 100); // calculate the final score
                
                                            echo "<p class='final-score'>Your final score is: <em><strong>{$final_score}%</strong></em></p>";
                                            if ($final_score == 0 ) { // return an error message if the score is 0
                                                echo "<p>Because your score is 0%, this attempt will not be saved, you must do the <a href='quiz.php'>quiz</a> again</p>";
                                            } else {
                                                if ($attempt == 1) {
                                                    echo "<p> This is your first attempt, you can try to do the <a class='try-again-link' href='quiz.php'>quiz</a> again</p>";
                                                } else if ($attempt == 2) {
                                                    echo "<p> This is your second attempt, you can't do the quiz again</p>";
                                                }
                                                $user_id = $_SESSION['user_id'];
                                                // create a new attempt
                                                $create_new_attempt_query = "INSERT INTO attempts (attempt_id,time,first_name,last_name,student_id,number_of_attempts,score,user_id) VALUES (NULL,'$current_date','$first_name','$last_name','$student_id',$attempt,$final_score,$user_id)";
                                                $create_new_attempt_query_result = mysqli_query($connection,$create_new_attempt_query);
                                                $created_attempt_id = mysqli_insert_id($connection);
                                                if ($create_new_attempt_query_result) {
                                                    // display the created attempt
                                                    echo "<p>Here is your attempt:</p>";
                                                    $get_created_attempt = "SELECT * FROM attempts WHERE attempt_id={$created_attempt_id}";
                                                    $get_created_attempt_result = mysqli_query($connection,$get_created_attempt);
                                                    if ($get_created_attempt_result) {
                                                        display_table($get_created_attempt_result);
                                                        mysqli_free_result($get_created_attempt_result);
                                                    } else {
                                                        echo "<p class='error'>Can't query the created attempts</p>";
                                                    }
                                                    
                                                } else {
                                                    echo "Can't create new attempt for some reason";
                                                }
                                            }
                                        }
                                    } else {
                                        echo "<p class='error'>You cannot do the quiz anymore because you have already had 2 attempts</p>";
                                    }
                                    mysqli_free_result($attempt_query_result); // free the pointer
                                } else {
                                    echo "<p class='error'>Can't query {$attempt_query}</p>";
                                }

                            } else {
                                echo $errMsg;
                                echo "<p class='error'>Do the <a href='quiz.php'>quiz</a> again</p>";
                            }
                            
                        } else {
                            echo "<p class='error'>Can't create attempts table</p>";
                        }
                        mysqli_close($connection);
                    }
                } else {
                    echo "<p class='error'>You must do the <a href='quiz.php'>quiz</a> first</p>";
                }
            } else {
                echo "<p class = 'error'>You must <a href='login.php'>login</a></p>";
            }
        ?>
    </section>
	<?php
	include_once("footer.inc"); // include the footer element
	?>
</body>
</html>