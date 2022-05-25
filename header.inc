<?php
    // Author: Anh Tuan Doan
    // Description: The footer element for all pages
    if ($page == 'index' or $page == 'login' or $page == 'register') {
        $header_class = "bg";
    } else {
        $header_class = "title-background";
    }
    // Make a different title for different pages
    if ($page == 'index') {
        $page_title = '
        <ul class="c-rainbow">
            <li class="c-rainbow__layer c-rainbow__layer--white">.JPEG</li>
            <li class="c-rainbow__layer c-rainbow__layer--orange">.JPEG</li>
            <li class="c-rainbow__layer c-rainbow__layer--red">.JPEG</li>
            <li class="c-rainbow__layer c-rainbow__layer--violet">.JPEG</li>
            <li class="c-rainbow__layer c-rainbow__layer--blue">.JPEG</li>
            <li class="c-rainbow__layer c-rainbow__layer--green">.JPEG</li>
            <li class="c-rainbow__layer c-rainbow__layer--yellow">.JPEG</li>
        </ul>';
    } else if ($page == 'topic') {
        $page_title = 'JPEG HISTORY';
    } else if ($page == 'quiz') {
        $page_title = 'JPEG Quizzes';
    } else if ($page == 'enhancements') {
        $page_title = 'Enhancements';
    } else if ($page == 'mark-quiz') {
        $page_title = 'Quiz Result';
    } else if ($page == 'manage') {
        $page_title = 'Manage Database';
    } else if ($page == 'change-score') {
        $page_title = 'Change score';
    } else if ($page == 'delete-attempts') {
        $page_title = 'Delete attempts';
    } else if ($page == 'student-attempts') {
        $page_title = 'Attempts';
    }
    else {
        $page_title = '';
    }
    // Add a different id to different pages
    if ($page=='topic')
        $header_id = 'topicimage';
    else if($page == 'quiz')
        $header_id = 'quizjpeg';
    else if ($page == 'enhancements')
        $header_id = 'enhancementsjpg';
    else if ($page == 'mark-quiz')
        $header_id = 'markquizimage';
    else if ($page == 'manage')
        $header_id = 'manageimage';
    else if ($page == 'change-score')
        $header_id = 'change-score-image';
    else if ($page == 'delete-attempts')
        $header_id = 'delete-attempts-image';
    else if ($page == 'student-attempts')
        $header_id = 'student-attempts-image';
    else
        $header_id = "header-element";
?>
    <header class='<?php echo $header_class; ?>' id='<?php echo $header_id; ?>'>
        <?php include_once("nav.inc"); // include the nav element ?>
        <h1 class='page-title'><?php echo $page_title; ?></h1>
    </header>

