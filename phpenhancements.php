<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="JPEG website enhancements">
    <meta name="keywords" content="JPEG">
    <meta name="author" content="Andrew Grivas">
    <title>Website enhancements</title>
	<link rel="stylesheet" href="styles/style.css">
</head>

<body>

    <?php
        
        $page = 'enhancements';
        include_once('header.inc');
    ?>
    <section class="main-content enhancement-content">
        <section id="hover-effect-section"  class="enhancement-section">
            <section class="section-information">
                <article class="information-container">
     
                    <h2>Dynamically generated questions</h2> 
                    
                    <p>
                    For the quiz page, the questions are generated dynamically from an SQL table called “questions”. This enhancement is done by using a special query: ‘SELECT * FROM questions ORDER BY RAND() LIMIT 5;’ which selects 5 random questions from the table. Within the table, there are 5 different question types including text, number, drop-down, checkboxes and radio buttons. These types are taken into account to generate valid HTML for the questions.
                    </p>
                    <p>
                        We implemented this enhancement in our quiz.php page, here is the link to the page:
                    
                        <a href="quiz.php">Quiz</a>.
                        We used this tutorial to help code the enhancement:
                    
                        <a target="_blank" href="https://www.mysqltutorial.org/select-random-records-database-table.aspx">MySQL Select Random Records</a>
                    </p>
                </article>
            </section>
 
            <img id="question-enhancement" src="images/enhancement1.png" alt="Quiz questions">
        
        </section>

        <section id="text-trail-effect-section" class="enhancement-section">

            <img id="authentication-enhancement" src="images/loginpage.png" alt="Login page image">
        
            <section class="section-information">
                <article class="information-container">

                    <h2>Authentication system</h2>
                    <p>
                    The second enhancement is the login page, as the user needs to log in to access the quiz and manage page. In order to register, the user must provide their email, username and password to make a new account. When the user tries to sign in with their email and password, the login page attempts to find a user with the specified email by using the code ‘SELECT * FROM users WHERE email = $email’. If the specified password matches the password in the user record, the page will create the session variable ‘SESSION[‘logged_in’]’ which is set to true to indicate that the user has logged in successfully. Moreover, if the user is an admin the session variable ‘SESSION[‘is_an_admin’]’ will also be set to true to allow access to the manage page where they can see and update the records.
                    </p>
                
                    <p>
                        We implemented the enhancement in our login.php and register.php pages. Here are the links to the pages:
                    
                        <a href="login.php">Login</a>,
                        <a href="register.php">Register</a>.
                        We used this tutorial to help code the enhancement:
                    
                        <a target="_blank" href="https://codeshack.io/secure-login-system-php-mysql/">Secure Login System with PHP and MySQL</a>
                    </p>
                </article>
            </section>
        </section>
    </section>
    <?php
    include_once("footer.inc");
    ?>
</body>
</html>
