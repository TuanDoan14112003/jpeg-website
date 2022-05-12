<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="JPEG quizzes">
    <meta name="keywords" content="JPEG">
    <meta name="author" content="Gabriel Chee">
    <title>JPEG Quizzes result</title>
	<link rel="stylesheet" href="styles/style.css">
</head>
<body>
<?php
	
	$page = 'mark-quiz';
	include_once("header.inc")
?>
    <section class="quiz-content main-content">
            <h2>JPEG Quiz Result</h2>
            <p>Here is your quiz result (you can redo the quiz if this is your first attempt):
            </p>
    </section>
</body>
</html>
<?php
include_once("sanitise_input.php");
date_default_timezone_set('Australia/Melbourne');
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['student_id'])) {
    require_once "database_credentials.php";
    $connection = mysqli_connect($host,$user,$pwd,$sql_db);
    if ($connection) {
        $errMsg = "";
        if (isset($_POST['first_name'])) {
            $first_name = $_POST['first_name'];
            $first_name = sanitise_input($first_name);
            if ($first_name == "") {
                $errMsg .= "<p>You must enter your first name</p>";
            } else if (!preg_match('/^[a-zA-Z- ]{1,30}$/',$first_name)) {
                $errMsg .= "<p>First name must be max 30 alpha|space|hyphen characters</p>";
            }
        }
        if (isset($_POST['last_name'])) {
            $last_name = $_POST['last_name'];
            $last_name = sanitise_input($last_name);
            if ($last_name == "") {
                $errMsg .= "<p>You must enter your last name</p>";
            } else if (!preg_match('/^[a-zA-Z- ]{1,30}$/',$last_name)) {
                $errMsg .= "<p>Last name must be max 30 alpha|space|hyphen characters</p>";
            }
        }
        if (isset($_POST['student_id'])) {
            $student_id = $_POST['student_id'];
            $student_id = sanitise_input($student_id);
            if ($student_id == "") {
                $errMsg .= "<p>You must enter your student id</p>";
            } else if (!preg_match('/^(\d{7}|\d{10})$/',$student_id)) {
                $errMsg .= "<p>The student ID must be either 7 or 10 digits numbers</p>";
            }
        }
        if ($errMsg == "") {
            $current_date = date('Y-m-d H:i:s');
            $attempt_query = "SELECT * FROM attempts WHERE student_id='{$student_id}'";
            $attempt_query_result = mysqli_query($connection,$attempt_query);
            $attempt = mysqli_num_rows($attempt_query_result) + 1;
            if ($attempt < 3) {
                if (isset($_POST['question_list'])) {
                    $question_list = explode(",",$_POST['question_list']);
                    $question_count = 0;
                    $total_correct_answer = 0;
                    echo $_POST['question_list'];
                    foreach ($question_list as $question_id) {
                        $question_count += 1;

                        $get_answer_query = "SELECT * FROM questions WHERE question_id={$question_id}";
                       
                        $query_result = mysqli_query($connection,$get_answer_query);
                        if ($query_result) {
                            $row = mysqli_fetch_assoc($query_result);
                            
            
                            if (isset($_POST["question_{$question_id}"])) {
                                
                                if ($row['question_type'] == 'check-boxes') {
                                    $correct_answers = json_decode($row['correct_answer']);
                                    $user_answers = $_POST["question_{$question_id}"];
                                    echo "<p>Your answers are:</p>";
                                    print_r($user_answers);
                                    echo "<p> The correct answers are </p>";
                                    print_r($correct_answers);
                                    sort($correct_answers);
                                    sort($user_answers);
                                    if ($correct_answers === $user_answers) {
                                        $total_correct_answer += 1;
                                        echo "<p>You were right!</p>";
                                    } else {
                                        echo '<p>You were wrong!</p>';
                                    }
                                    
                                } else {
                                    $correct_answer =$row['correct_answer'];
                                    $user_answer = $_POST["question_{$question_id}"];
                                    echo "<p>{$row['question']}</p>";
                                    echo "<p>For question {$question_count}, your answer is $user_answer while the correct answer is {$correct_answer}</p>";

                                    if (strtolower($correct_answer) == strtolower($user_answer)) {
                                        $total_correct_answer += 1;
                                        echo "<p>You were right!</p>";
                                    } else {
                                        echo '<p>You were wrong!</p>';
                                    }
                                }
                                echo '--------';
                            }
                        } else {
                            echo "can't query";
                        }
                    }
                    $final_score = number_format($total_correct_answer / $question_count * 100);
                    echo "<p>Hi $first_name</p>";
                    echo "<p> Student id: {$student_id} </p>";
                    echo "<p>Your score is: {$final_score} </p>";
                    if ($attempt == 1) {
                        echo "<p> This is your first attempt, you can try again to do the <a href='quiz.php'>quiz</a> again</p>";
                    } else if ($attempt == 2) {
                        echo "<p> This is your second attempt, and you can't do the quiz again</p>";
                    }
                    $create_new_attempt_query = "INSERT INTO attempts (attempt_id,time,first_name,last_name,student_id,number_of_attempts,score) VALUES (NULL,'$current_date','$first_name','$last_name','$student_id',$attempt,$final_score)";
                    $create_new_attempt_query_result = mysqli_query($connection,$create_new_attempt_query);
                    if ($create_new_attempt_query_result) {
                        echo "created new attempt";
                    } else {
                        echo "Can't create new attempt for some reason";
                    }
                }
            } else {
                echo "<p>Can't do the quiz anymore because you have already had 2 attempts</p>";
            }
        } else {
            echo $errMsg;
        }
        mysqli_close($connection);
    }
} else {
    echo "You must do the quiz first";
}
?>