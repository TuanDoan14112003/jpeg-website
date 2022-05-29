
<?php
    /*
    filename: menu.inc
    author: Anh Tuan Doan
    created: 10/5/2022  
    last modified: 29/5/2022
    description: nav element for all pages
    */
    if(!isset($_SESSION)) session_start(); 
    if (isset($_SESSION['username'])) { // display a welcome message if the user is logged in
        $welcome_message = "<li><a>Welcome, {$_SESSION['username']}</a></li>";
    } else $welcome_message = "";
    if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == true) { // Display a login/logout link if the user is logged in
        $login_link = "";
        $logout_link = "<li><a href='logout.php'>Logout</a></li>";
    } else {
        $logout_link = "";
        $login_link = "<li><a href='login.php'>Login</a></li>";
    }
?>


<nav id='navigation'>
    <ul class='nav_links'>
        <li><a href='index.php'>Home</a></li>
        <li><a href='topic.php'>Information</a></li>
        <li><a href='quiz.php'>Quizzes</a></li>
        <li><a href='manage.php'>Manage</a></li>
        <li><a href='phpenhancements.php'>PHP Enhancements</a></li>
        <li><a target='_blank' href='https://www.youtube.com/watch?v=qy49glQ4aDc'>Demonstration Video</a></li>
        <?php
        echo $welcome_message;
        echo $login_link;
        echo $logout_link;
        ?>
    </ul>
</nav>



