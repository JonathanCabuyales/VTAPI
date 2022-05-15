<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

/* $json = file_get_contents('php://input');
$jsonCompra = json_decode($json);

$valor = $jsonCompra->buscar; */
$valor = $_GET['buscar'];

$query = "SELECT * FROM anexos ag
WHERE ag.id_grupo_anexo = '$valor'";

include('../conexion/bd.php');

$result = mysqli_query($con, $query);

$data= array();

if ($result) {
    $array = array();
    while ($fila = mysqli_fetch_assoc($result) ) {	
        // echo json_encode($fila);
        $data[] = array_map('utf8_encode', $fila);
    }
}else{
    $res = array();
}


$res = $data;

    $data_insert=array(
        "data" => $res,
        "buscar" => $valor,
        "status" => "success",
        "message" => "Request authorized",
        'resultado' => $result
    );  


echo json_encode($data_insert);

