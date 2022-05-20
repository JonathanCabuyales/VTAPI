<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=UTF-8'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json');

include ("../conexion/bd.php");

// $usuario = $_GET["usuario"];

$data=array(); 

$get = mysqli_query($con, "SELECT * FROM registrofechacuentas rf, anexos a
WHERE rf.id_cuenta = a.id_grupo_anexo ORDER BY fecharegistro ASC");

// WHERE create_at BETWEEN '$fechaActual 00:00:00' AND '$fechaActual 23:59:59'
if ($get) {
    $array = array();
    while ($fila = mysqli_fetch_assoc($get) ) {	
        // echo json_encode($fila);
        $data[] = $fila;
    }
}else{
    echo "fallo no hay nada";
    $res = null;
    echo mysqli_error($con);
}

$res = $data;

echo json_encode($res, JSON_UNESCAPED_UNICODE); 
echo mysqli_error($con);