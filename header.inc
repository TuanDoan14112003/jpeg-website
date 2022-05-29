<?php
    /*
    filename: header.inc
    author: Anh Tuan Doan
    created: 10/5/2022  
    last modified: 29/5/2022
    description: header element for all pages
    */
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
        $page_title = "<h1 class='page-title'>JPEG HISTORY</h1>";
    } else if ($page == 'quiz') {
        $page_title = "<h1 class='page-title'>JPEG Quizzes</h1>";
    } else if ($page == 'enhancements') {
        $page_title = "<h1 class='page-title'>Enhancements</h1>";
    } else if ($page == 'mark-quiz') {
        $page_title = "<h1 class='page-title'>Quiz Result</h1>";
    } else if ($page == 'manage') {
        $page_title = "<h1 class='page-title'>Database Management</h1>";
    } else if ($page == 'change-score') {
        $page_title = "<h1 class='page-title'>Change score</h1>";
    } else if ($page == 'delete-attempts') {
        $page_title = "<h1 class='page-title'>Delete attempts</h1>";
    } else if ($page == 'student-attempts') {
        $page_title = "<h1 class='page-title'>Attempts</h1>";
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
        <?php include_once("menu.inc"); // include the nav element ?>
        <?php echo $page_title; ?>
    </header>

