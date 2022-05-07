<?php
date_default_timezone_set('Australia/Melbourne');
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['student_id'])) {
    require_once "database_credentials.php";
    $connection = mysqli_connect($host,$user,$pwd,$sql_db);
    if ($connection) {
        if (isset($_POST['first_name'])) {
            $first_name = $_POST['first_name'];
        }
        if (isset($_POST['last_name'])) {
            $last_name = $_POST['last_name'];
        }
        if (isset($_POST['student_id'])) {
            $student_id = $_POST['student_id'];
        }
        $current_date = date('Y-m-d H:i:s');
        $attempt_query = "SELECT * FROM attempts WHERE student_id='{$student_id}'";
        $attempt_query_result = mysqli_query($connection,$attempt_query);
        $attempt = mysqli_num_rows($attempt_query_result) + 1;
        if ($attempt < 3) {
            if (isset($_POST['question_list'])) {
                $question_list = explode(",",$_POST['question_list']);
                $question_count = 0;
                $total_correct_answer = 0;
                foreach ($question_list as $question) {
                    $question_count += 1;
                    $question_id = substr($question,-1);
                    $get_answer_query = "SELECT correct_answer FROM questions WHERE question_id={$question_id}";
                    $query_result = mysqli_query($connection,$get_answer_query);
                    if ($query_result) {
                        $row = mysqli_fetch_assoc($query_result);
                        if (isset($_POST[$question])) {
                            if (strtolower($row['correct_answer']) == strtolower($_POST[$question])) {
                                $total_correct_answer += 1;
                            } else {
                                echo 'wrong';
                            }
                            echo $row['correct_answer'],strtolower($_POST[$question]);
                            echo "<br>";
                        }
                    } else {
                        echo "can't query";
                    }
                }
                $final_score = number_format($total_correct_answer / $question_count * 100);
                echo $final_score;
                
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
        mysqli_close($connection);
    }
} else {
    echo "You must do the quiz first";
}
?>