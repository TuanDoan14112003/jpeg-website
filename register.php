<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="JPEG register">
    <meta name="keywords" content="JPEG">
    <meta name="author" content="Anh Tuan Doan">
    <title>Register</title>
	<link rel="stylesheet" href="styles/style.css">
</head>
<body>
<?php
        include_once("sanitise_input.php");
        if(!isset($_SESSION)) session_start(); 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once "database_credentials.php";
            $connection = mysqli_connect($host,$user,$pwd,$sql_db);
            if ($connection) {
                // Create the 'users' database if it doesn't already exists
                $create_table_if_not_exists_query = "CREATE TABLE if not exists users( user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                                                                         email VARCHAR(100) NOT NULL, 
                                                                         username VARCHAR(50) NOT NULL, 
                                                                         password CHAR(60) NOT NULL, 
                                                                         admin BOOLEAN NOT NULL );";
                $create_table_if_not_exists_query_result = mysqli_query($connection,$create_table_if_not_exists_query);
                if ($create_table_if_not_exists_query_result) {
                    $error_message = '';
                    if (isset($_POST['email']) and isset($_POST['username']) and isset($_POST['password']) and isset($_POST['confirm_password'])) {
                        if (isset($_POST['email'])) {
                            $email = $_POST['email'];
                            $email = sanitise_input($email);
                            if ($email == "") {
                                $error_message .= "<p class='error'>You must enter your email</p>";
                            }
                        }
                        if (isset($_POST['username'])) {
                            $username = $_POST['username'];
                            $username = sanitise_input($username);
                            if ($username == "") {
                                $error_message .= "<p class='error'>You must enter your username</p>";
                            }
                        }
                        if (isset($_POST['password'])) {
                            $password = $_POST['password'];
                            $password = sanitise_input($password);
                            if ($password == "") {
                                $error_message .= "<p class='error'>You must enter your password</p>";
                            } else if (strlen($password) < 8)  {
                                $error_message .= "<p class='error'>Your password must contain at least 8 characters</p>";
                            }
                        }
                        if (isset($password) and isset($_POST['confirm_password'])) {
                            $confirm_password = $_POST['confirm_password'];
                            $confirm_password = sanitise_input($confirm_password);
                            if ($confirm_password == "") {
                                $error_message .= "<p class='error'>You must confirm your password</p>";
                            } else if ($confirm_password != $password)  {
                                $error_message .= "<p class='error'>Your password doesn't match your confirmed password</p>";
                            }
                        }
                        
                        if ($error_message == "") {
                            $check_if_account_exists = "select * from users where email = '$email'";  // find an account with the specified details
                            $check_if_account_exists_result = mysqli_query($connection, $check_if_account_exists);  
                            if ($check_if_account_exists_result) { // Make a new account if there aren't any account with that email in the database
                                $count = mysqli_num_rows($check_if_account_exists_result);  
                                if($count == 0){  
                                    
                                    $create_new_account_query = "INSERT INTO users (user_id,email,username,password,admin) VALUES (NULL,'$email','$username','$password','false')";
                                    $create_new_account_query_result = mysqli_query($connection,$create_new_account_query);
                                    if ($create_new_account_query_result) {
                                        $_SESSION['created_new_account_message'] = "<p class='created_new_account_message'>Your account has been created, now you can login</p>"; // Let the user know that they have successfully created a new account.
                                        
                                        header("Location: login.php"); // return to the login page
                                    } else {
                                        $_SESSION['error_message'] = "<p class='error'>Can't create new account</p>";
                                    }
                                }  
                                else{  // If there is already an account with that email, return an error message
                                    $_SESSION['error_message'] = "<p class='error'>An user with this email already exists</p>";
                                }     
                               mysqli_free_result($check_if_account_exists_result); // free the pointer
                            } else {
                                $_SESSION['error_message'] = "<p class='error'>Can't check if account exists</p>";
                            }
                        } else {
                            $_SESSION['error_message'] = $error_message;
                        }
    
     
                    } else {
                        $_SESSION['error_message'] = "<p class='error'>You have not entered the details</p>";
                    }
                    
                } else {
                    echo "<p class='error'>Can not create database</p>";
                } 
            } else {
                echo "<p class='error'>Can't connect to database</p>";
            }
            mysqli_close($connection);
        }
?>
    <?php include_once("nav.inc"); ?>
    <section class="authentication-background">
        <section class = "authentication-form">
            <div class="authentication-form-box">
                <h2 class = "authentication-form-title">Register</h2>
                <form method="post" action="register.php">
                    <div class = "authentication-form-row">
                        <div class="authentication-form-item">
                            <div class="authentication-form-input">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email">
                            </div>
                        </div>
                    </div>
                    <div class = "authentication-form-row">
                        <div class="authentication-form-item">
                            <div class="authentication-form-input">
                                <label for="username">Username:</label>
                                <input type="text" id="username" name="username">
                            </div>
                        </div>
                    </div>
                    
                    <div class = "authentication-form-row">
                        <div class="authentication-form-item">
                            <div class="authentication-form-input">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password">
                            </div>
                        </div>
                    </div>
                    <div class = "authentication-form-row">
                        <div class="authentication-form-item">
                            <div class="authentication-form-input">
                                <label for="confirm_password">Confirm password:</label>
                                <input type="password" id="confirm_password" name="confirm_password">
                            </div>
                        </div>
                    </div>
                    <?php  if(isset($_SESSION['error_message'])) { echo $_SESSION['error_message']; } ?>
                    <div class = "authentication-form-row">
                        <div class="authentication-form-item">
                            <button class="authentication-form-submit-button" type="submit">Create a new account</button>
                        </div>
                    </div>

                    
                    
                    
                    
                </form>
            </div>
        </section>
    </section>
    <?php unset($_SESSION['error_message']); ?>
</body>
</html>