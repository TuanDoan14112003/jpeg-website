<?php
    if ($page == 'index' or $page == 'login' or $page == 'register') {
        $header_class = "bg";
    } else {
        $header_class = "title-background";
    }
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
        $page_title = '<h1 class="page-title">JPEG HISTORY</h1>';
    } else if ($page == 'quiz') {
        $page_title = '<h1 class="page-title">JPEG Quizzes</h1>';
    } else if ($page == 'enhancements') {
        $page_title = '<h1 class="page-title">Enhancements</h1>';
    } else if ($page == 'mark-quiz') {
        $page_title = '<h1 class="page-title">Quiz Result</h1>';
    } else {
        $page_title = '';
    }
    if ($page=='topic')
        $header_id = 'topicimage';
    else if($page == 'quiz')
        $header_id = 'quizjpeg';
    else if ($page == 'enhancements')
        $header_id = 'enhancementsjpg';
    else if ($page == 'mark-quiz')
        $header_id = 'markquizimage';
    else
        $header_id = "header-element";

    echo "<header class='{$header_class}' id='{$header_id}'>";
    include_once("nav.inc");
    echo $page_title; 
    echo "</header>";

?>