<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="JPEG login">
    <meta name="keywords" content="JPEG">
    <meta name="author" content="Anh Tuan Doan">
    <title>Login</title>
	<link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <?php
        include_once("sanitise_input.php");
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once "database_credentials.php";
            $connection = mysqli_connect($host,$user,$pwd,$sql_db);
            if ($connection) {
                echo "<p>Successfully</p>";
                $errorMSG = '';
                if (isset($_POST['student_id']) and isset($_POST['password'])) {
                    $student_id = sanitise_input($_POST['student_id']);
                    $password = sanitise_input($_POST['password']);

                    $validate_account_query = "select * from users where student_id = '$student_id' and password = '$password'";  
                    $validate_account_query_result = mysqli_query($connection, $validate_account_query);  
                    if ($validate_account_query_result) {
                        echo "<p>query success</p>";
                        $row = mysqli_fetch_array($validate_account_query_result, MYSQLI_ASSOC);  
                        $count = mysqli_num_rows($validate_account_query_result);  
                        
                        if($count == 1){  
                            echo "<h1>Login successful</h1>";  
                                        
                            // Store data in session variables
                            $_SESSION["logged_in"] = true;
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
        include_once("nav.inc");
    ?>

    <section class="authentication-background">
        <section class="authentication-title">
            <h2 >Welcome to</h2>
            <h1>JPEG WEB</h1>
        </section>
        <section class = "authentication-form">
            <div class="authentication-form-box">
                <h2 class = "authentication-form-title">Login</h2>
                <form method="post" action="login.php">
                    <div class = "authentication-form-row">
                        <div class="authentication-form-item">
                            <div class="authentication-form-input">
                                <!-- <label for="email">Email</label> -->
                                <input type="text" id="email" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class = "authentication-form-row">
                        <div class="authentication-form-item">
                            <div class="authentication-form-input">
                                <!-- <label for="password">Password</label> -->
                                <input type="password" id="password" name="password" required>
                            </div>
                        </div>
                    </div>
                    <div class = "authentication-form-row">
                        <div class="authentication-form-item">
                            <button class="authentication-form-submit-button" type="submit">Create account</button>
                        </div>
                    </div>

                    
                    
                    <?php  if(!empty($_SESSION['errMsg'])) { echo $_SESSION['errMsg']; } ?>
                    
                </form>
            </div>
        </section>
    </section>
    <?php unset($_SESSION['errMsg']); ?>
</body>
</html>