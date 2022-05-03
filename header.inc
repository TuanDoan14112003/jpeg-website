<header class="<?php echo ($page=='index')? 'bg':'title-background'; ?>" 
id="<?php 
if ($page=='topic')
    echo 'topicimage';
else if($page == 'quiz')
    echo 'quizjpeg';
else if ($page == 'enhancements')
    echo 'enhancementsjpg';
?>">
    <nav id="navigation">
        <ul class="nav_links">
            <li><a href="index.php">Home</a></li>
            <li><a href="topic.php">Information</a></li>
            <li><a href="quiz.php">Quizzes</a></li>
            <li><a href="enhancements.php">Enhancements</a></li>
            <li><a target="_blank" href="https://www.youtube.com/watch?v=TmwScvE_rLE">Demonstration Video</a></li>
        </ul>
    </nav>
    <!-- The title of the page: -->
    <?php echo $page_title; ?>
</header>

