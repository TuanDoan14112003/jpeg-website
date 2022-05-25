<?php
// Author: Anh Tuan Doan
// Description: The sanitise_input function that cleanse inputs
function sanitise_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>