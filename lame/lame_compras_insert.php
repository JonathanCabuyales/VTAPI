<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$json = file_get_contents('php://input');

$jsonCompra = json_decode($json);

if (!$jsonCompra) {
    exit("No hay datos para registrar");
}

$descripcion = $jsonCompra->descripcion;
$subtotal = $jsonCompra->subtotal;
$iva = $jsonCompra->iva;
$valor_iva = $jsonCompra->valor_iva;
$empresa = $jsonCompra->empresa;
$tipo = $jsonCompra->tipo;
$descuento = $jsonCompra->descuento;
$total = $jsonCompra->total;
$fecharegistro = date('Y-m-d H:i:s');




$query = "INSERT INTO compras
(
    factura_num,
    fecha_fac,
    autorizacionSRI,
    descripcion,
    subtotal,
    iva,
    valo_iva,
    fecha_registro,
    fecha_autorizacion,
    fecha_emision,
    empresa,
    tipo,
    descuento,
    total
)
VALUES (
    '$factura_num',
    '$fecha_fac',
    '$autorizacionSRI',
    '$descripcion',
    '$subtotal',
    '$iva',
    '$valor_iva',
    '$fecharegistro',
    '',
    '',
    '$empresa',
    '$tipo',
    '',
    '$total'   

)";


try{
    include ('../conexion/bd.php');

    $result = $con->query($query);
    if($result){
        echo json_encode(
            array(
                'insertado' => $result,
                'message' => 'Se ha insertado correctamente',
                'code' => 200
            )
            );
    }else{
        echo json_encode(
            array(
                'insertado' => $result,
                'message' => 'no se ha podido insertar',
                'code' => 401
            )
        );
    }


}

catch(Exception $e){
    echo json_encode(
        array(
            'resultado' => false,
            'message' => 'no se pudo insertar',
            'code' => 401
        ),
        JSON_UNESCAPED_UNICODE
    );
}



?>