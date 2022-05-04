<?php
require_once "database_credentials.inc";
function display_query($result) {
    echo "<table border='1'>";
    echo "<tr><th>Attempt_id</th><th>student_id</th><th>first_name</th>
    <th>last name</th><th>score</th><th>number of attempt</th></tr>";
        $row = mysqli_fetch_assoc($result);
        while ($row) {
        echo "<tr><td>{$row['attempt_id']}</td>";
        echo "<td>{$row['student_id']}</td>";
        echo "<td>{$row['first_name']}</td>";
        echo "<td>{$row['last_name']}</td>";
        echo "<td>{$row['score']}</td>";
        echo "<td>{$row['number_of_attempts']}</td></tr>";
        $row = mysqli_fetch_assoc($result);
        }
}
$connection = mysqli_connect($host,$user,$pwd,$sql_db);
if ($connection) {
    echo "Successfully";
    // $query1 = "SELECT * FROM attempts";
    // $result1 = mysqli_query ($connection, $query1);
    // if($result1) {
    //     display_query($result1);
    // } else {
    //     echo "can't query";
    // }

    // $student_id = '1000000';
    // $name = '';
    // $query2 = "SELECT * FROM attempts WHERE student_id='$student_id' OR first_name='$name'";
    // $result2 = mysqli_query ($connection, $query2);
    // if($result2) {
    //     display_query($result2);
    // } else {
    //     echo "can't query";
    // }

    // $query3 = "SELECT * FROM attempts WHERE number_of_attempts=1 AND score=100";
    // $result3 = mysqli_query ($connection, $query3);
    // if($result3) {
    //     display_query($result3);
    // } else {
    //     echo "can't query";
    // }

    // $query4 = "SELECT * FROM attempts WHERE number_of_attempts=2 AND score<50";
    // $result4 = mysqli_query ($connection, $query4);
    // if($result4) {
    //     display_query($result4);
    // } else {
    //     echo "can't query";
    // }
    
    $student_id = '100';
    $query5 = "DELETE FROM attempts WHERE student_id=$student_id";
    $result5 = mysqli_query($connection, $query5);
    echo "<h1>hi</h1>";



    if($result5) {
        // display_query($result5);
        echo gettype($result5);
    } else {
        echo "can't query";
    }

    // $student_id = '';
    // $new_score = 95;
    // $attempts = 1;
    // $query6 = "UPDATE attempts SET score=$new_score WHERE student_id=$student_id AND number_of_attempts=$attempts";

    mysqli_close($connection);
} else {
    echo "no";
}
?>