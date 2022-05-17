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
        if(!isset($_SESSION)) session_start(); 
        if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == true) {
            header("Location: index.php");
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once "database_credentials.php";
            $connection = mysqli_connect($host,$user,$pwd,$sql_db);
            if ($connection) {
                $create_table_if_not_exists_query = "CREATE TABLE if not exists users( user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                                                                         email VARCHAR(100) NOT NULL, 
                                                                         username VARCHAR(50) NOT NULL, 
                                                                         password CHAR(60) NOT NULL, 
                                                                         admin BOOLEAN NOT NULL );";
                $create_table_if_not_exists_query_result = mysqli_query($connection,$create_table_if_not_exists_query);
                if ($create_table_if_not_exists_query_result) {
                    $errorMSG = '';
                    if (isset($_POST['email']) and isset($_POST['password'])) {
                        $error_message = "";
                        if (isset($_POST['email'])) {
                            $email = $_POST['email'];
                            $email = sanitise_input($email);
                            if ($email == "") {
                                $error_message .= "<p class='error'>You must enter your email</p>";
                            }
                        }
                        if (isset($_POST['password'])) {
                            $password = $_POST['password'];
                            $password = sanitise_input($password);
                            if ($password == "") {
                                $error_message .= "<p class='error'>You must enter your password</p>";
                            }
                        }
                        if ($error_message == "") {
                            $validate_account_query = "select * from users where email = '$email'";  
                            $validate_account_query_result = mysqli_query($connection, $validate_account_query);  
                            if ($validate_account_query_result) {
                                $row = mysqli_fetch_array($validate_account_query_result, MYSQLI_ASSOC);  
                                $count = mysqli_num_rows($validate_account_query_result);  
                                
                                if($count == 1){  
        
                                    // Redirect user to welcome page
                                    if ($password == $row['password']) {
                                        $_SESSION["logged_in"] = true;
                                        $_SESSION["username"] = $row['username'];
                                        $_SESSION["is_an_admin"] = $row['admin'];
                                        $_SESSION["user_id"] = $row['user_id'];
                                        header("Location: index.php");
                                    } else {
                                        $_SESSION['error_message'] = "<p class='error'>Invalid username or password</p>";
                                    }
                                }  
                                else{  
                                    $_SESSION['error_message'] = "<p class='error'>Invalid username or password</p>";
                                }     
                                
                            } else {
                                $_SESSION['error_message'] =  "<p class='error'>Can't query</p>";
                            }
                        } else {
                            $_SESSION['error_message'] = $error_message;
                        }

                    } else {
                        $_SESSION['error_message'] = "<p class='error'>You have not entered the email and password</p>";
                    }
                    
                } else {
                    echo "<p class='error'>Cannot create database</p>";
                }    
            } else {
                echo "Can't connect to database";
            }
            mysqli_close($connection);
        }
        
    ?>
    <?php include_once("nav.inc"); ?>
    <section class="authentication-background">
        <section class = "authentication-form">
            <div class="authentication-form-box">
                <h2 class = "authentication-form-title">Login</h2>
                <?php if (isset($_SESSION['created_new_account_message'])) echo $_SESSION['created_new_account_message']; ?>
                <form method="post" action="login.php">
                    <div class = "authentication-form-row">
                        <div class="authentication-form-item">
                            <div class="authentication-form-input">
                                <label for="email">Email:</label>
                                <input type="text" id="email" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class = "authentication-form-row">
                        <div class="authentication-form-item">
                            <div class="authentication-form-input">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" required>
                            </div>
                        </div>
                    </div>
                    <div class = "authentication-form-row">
                        <div class="authentication-form-item">
                           <p class='no-account-message'>You don't have an account? <a href="register.php">Register</a></p>
                        </div>
                    </div>
                    <div class = "authentication-form-row">
                        <div class="authentication-form-item">
                            <button class="authentication-form-submit-button" type="submit">Sign in</button>
                        </div>
                    </div>

                    
                    
                    <?php  if(isset($_SESSION['error_message'])) { echo $_SESSION['error_message']; } ?>
                    
                </form>
            </div>
        </section>
    </section>
    <?php unset($_SESSION['error_message']); unset($_SESSION['created_new_account_message']); ?>
</body>
</html>