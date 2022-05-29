<?php
/*
filename: sanitise_input.php
author: Anh Tuan Doan
created: 13/5/2022  
last modified: 29/5/2022
description: sanitise_input function
*/
function sanitise_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>