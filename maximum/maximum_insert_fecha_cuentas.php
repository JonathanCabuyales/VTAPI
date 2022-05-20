<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// $id_cuenta = $_GET['id'];
// $fecha = $_GET['fecha'];

$json = file_get_contents('php://input');

$jsonNota = json_decode($json);


if(!$jsonNota){
    exit('No existen datos para insertar');
}

include('../conexion/bd.php');


// $res = array();

try{
    $id_cuenta = $jsonNota->id_cuenta;
    $fecha = $jsonNota->fecha;
    $query = "INSERT INTO registrofechacuentas (id_cuenta, fecharegistro) VALUES ('$id_cuenta', '$fecha')";
    $result = mysqli_query($con, $query);

    if($result){
        echo json_encode(
            array(
                'insertado' => $result,
                'status' => 'ok',
                'message' => 'autorizado',
                'code' => 200
            ),
            JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE
            );
    }
}
catch(Exception $e){
    echo json_encode(
        array(
            'message' => 'hubo un error con el controlador',
            'code' => 500,
            'status' => 'no autorizado'

        ),
        JSON_UNESCAPED_UNICODE  |JSON_INVALID_UTF8_IGNORE
        );
}