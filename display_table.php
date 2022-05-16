<?php
function display_table($result) {
    $fields = mysqli_fetch_fields($result);
    echo "<table class='information-table'><thead><tr>";
    foreach($fields as $field) {
        echo "<th>{$field->name}</th>";
    }
    echo "</tr></thead><tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
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