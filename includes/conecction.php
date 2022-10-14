<?php

    $con = new mysqli("localhost", "root", "12345678", "db_supervicion");
    if ($mysqli->connect_errno) {
        echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

?>