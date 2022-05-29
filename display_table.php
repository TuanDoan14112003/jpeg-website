<?php
/*
filename: display_table.php
author: Anh Tuan Doan
created: 10/5/2022  
last modified: 29/5/2022
description: display a query result as a table
*/
function display_table($result) {
    $fields = mysqli_fetch_fields($result); // get the columns from the result
    echo "<table class='information-table'><thead><tr>";
    foreach($fields as $field) {
        echo "<th>{$field->name}</th>"; 
    }
    echo "</tr></thead><tbody>";
    while ($row = mysqli_fetch_assoc($result)) { // get the rows from the result.
        echo "<tr>";
        foreach($fields as $field) {
            $name = $field->name;
            echo "<td>{$row[$name]}</td>";
        }
        echo "</tr>";
    }
    echo "</tbody></table>";
}
?>