<?php
require_once "database_credentials.inc";
$connection = mysqli_connect($host,$user,$pwd,$sql_db);
if ($connection) {
    echo "Successfully";
    mysqli_close($connection);
} else {
    echo "no";
}
?>