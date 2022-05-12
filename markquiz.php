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
    <section class="mark-quiz-content main-content">
            <h2>JPEG Quiz Result</h2>
<?php
function display_table($result) {
    echo "<table id='other-tech-table'>
            <thead>
                <tr>
                    <th>Attempt id</th>
                    <th>Time</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Student id</th>
                    <th>Number of attempts</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>{$row['attempt_id']}</td>
            <td>{$row['time']}</td>
            <td>{$row['first_name']}</td>
            <td>{$row['last_name']}</td>
            <td>{$row['student_id']}</td>
            <td>{$row['number_of_attempts']}</td>
            <td>{$row['score']}</td>
        </tr>";
    }
    echo "  </tbody>
        </table>";
}
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
                    echo "<section class='student-info'>";
                    echo "<p>Student name: <em><strong>{$first_name}</strong></em></p>";
                    echo "<p> Student id: <em><strong>{$student_id}</strong></em></p>";
                    echo "</section>";
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

                                    // echo "<p> The correct answers are </p>";
                                    // print_r($correct_answers);
                                    sort($correct_answers);
                                    sort($user_answers);
                                    echo "<p class='question'>Q) {$row['question']}</p>";
                                    if ($correct_answers === $user_answers) {
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
                                    
                                } else {
                                    $correct_answer =$row['correct_answer'];
                                    $user_answer = sanitise_input($_POST["question_{$question_id}"]);
                                    echo "<p class='question'>Q) {$row['question']}</p>";
                                 
                                    // echo "<p >For question {$question_count}, your answer is $user_answer while the correct answer is {$correct_answer}</p>";

                                    if (trim(strtolower($correct_answer)) == strtolower($user_answer)) {
                                     
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
                        } else {
                            echo "can't query";
                        }
                    }
                    $final_score = number_format($total_correct_answer / $question_count * 100);

                    echo "<p class='final-score'>Your final score is: <em><strong>{$final_score}%</strong></em></p>";
                    if ($attempt == 1) {
                        echo "<p> This is your first attempt, you can try again to do the <a href='quiz.php'>quiz</a> again</p>";
                    } else if ($attempt == 2) {
                        echo "<p> This is your second attempt, and you can't do the quiz again</p>";
                    }
                    $create_new_attempt_query = "INSERT INTO attempts (attempt_id,time,first_name,last_name,student_id,number_of_attempts,score) VALUES (NULL,'$current_date','$first_name','$last_name','$student_id',$attempt,$final_score)";
                    $create_new_attempt_query_result = mysqli_query($connection,$create_new_attempt_query);
                    $created_attempt_id = mysqli_insert_id($connection);
                    if ($create_new_attempt_query_result) {
                        echo "<p>Here is your attempt:</p>";
                        $get_created_attempt = "SELECT * FROM attempts WHERE attempt_id={$created_attempt_id}";
                        $get_created_attempt_result = mysqli_query($connection,$get_created_attempt);
                        if ($get_created_attempt_result) {
                            display_table($get_created_attempt_result);
                        } else {
                            echo "<p>Can't query the created attempts</p>";
                        }
                        
                    } else {
                        echo "Can't create new attempt for some reason";
                    }
                }
            } else {
                echo "<p>You cannot do the quiz anymore because you have already had 2 attempts</p>";
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
    </section>
	<?php
	include_once("footer.inc")
	?>
</body>
</html>