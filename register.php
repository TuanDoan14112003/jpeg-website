<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <?php
    session_start();
    if (isset($_POST["logged_in"])) {
        header("location:index.html");
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST'){ 
        
    }
    ?>
    <form method="post" action="register.php">
        <input type="text" name="first_name" required>
        <input type="text" name="last_name" required>
        <input type="text" name="email" required>
        <input type="text" name="password" required>
        <?php  if(!empty($_SESSION['errMsg'])) { echo $_SESSION['errMsg']; } ?>
        <button type="submit">Create a new account</button>
    </form>
</body>
</html>