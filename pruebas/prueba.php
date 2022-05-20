<?php

    include('../conexion/bd.php');

    $query = "SELECT * FROM anexos";
    $result = $con->query($query);

    // $row = $result->fetch_assoc();
    $data = array();
    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode(
        $data,
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );





?>