<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once "database_credentials.php";
            $connection = mysqli_connect($host,$user,$pwd,$sql_db);
            if ($connection) {
                echo "<p>Successfully</p>";
                $errorMSG = '';
                if (isset($_POST['student_id']) and isset($_POST['password'])) {
                    $student_id = $_POST['student_id'];
                    $password = $_POST['password'];

                    $validate_account_query = "select * from users where student_id = '$student_id' and password = '$password'";  
                    $validate_account_query_result = mysqli_query($connection, $validate_account_query);  
                    if ($validate_account_query_result) {
                        echo "<p>query success</p>";
                        $row = mysqli_fetch_array($validate_account_query_result, MYSQLI_ASSOC);  
                        $count = mysqli_num_rows($validate_account_query_result);  
                        
                        if($count == 1){  
                            echo "<h1>Login successful</h1>";  
                                        
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["student_id"] = $row['student_id'];
                            $_SESSION["name"] = $row['first_name'];

                            // Redirect user to welcome page
                
                        }  
                        else{  
                            $_SESSION['errMsg'] = 'Invalid username/password';
                        }     
                    } else {
                        echo "<p>Can't query</p>";
                    }
                } else {
                    $_SESSION['errMsg'] = "<p>You have not entered the student id and password</p>";
                }

                
            } else {
                echo "Can't connect to database";
            }
            mysqli_close($connection);
        }
        
    ?>
    <form method="post" action="login.php">
        <input type="text" name="student_id">
        <input type="text" name="password">
        <?php  if(!empty($_SESSION['errMsg'])) { echo $_SESSION['errMsg']; } ?>
        <button type="submit">GO</button>
    </form>
    <?php unset($_SESSION['errMsg']); ?>
</body>
</html>