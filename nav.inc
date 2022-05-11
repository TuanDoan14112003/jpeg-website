
<?php
    session_start();
    if (isset($_SESSION['name'])) {
        $welcome_message = "<li><a>Welcome, {$_SESSION['name']}</a></li>";
    } else $welcome_message = "";
    echo "
    <nav id='navigation'>
        <ul class='nav_links'>
            <li><a href='index.php'>Home</a></li>
            <li><a href='topic.php'>Information</a></li>
            <li><a href='quiz.php'>Quizzes</a></li>
            <li><a href='enhancements.php'>Enhancements</a></li>
            <li><a target='_blank' href='https://www.youtube.com/watch?v=TmwScvE_rLE'>Demonstration Video</a></li>
            {$welcome_message}
        </ul>
    </nav>
    ";
?>

