<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../jwt/src/BeforeValidException.php';
require_once '../jwt/src/ExpiredException.php';
require_once '../jwt/src/SignatureInvalidException.php';
require_once '../jwt/src/JWT.php';
use \Firebase\JWT\JWT;

define ('SECRET_KEY', '4956andres.'); // la clave secreta puede ser una cadena aleatoria y mantenerse en secreto para cualquier persona
define ('ALGORITMO', 'HS256'); // Algoritmo utilizado para firmar el token

$json = file_get_contents('php://input');
 
$jsonProdser = json_decode($json);

if (!$jsonProdser) {
    exit("No hay datos para registrar");
}

$jwt = $jsonProdser;

try {
    JWT::$leeway = 10;
    $decoded = JWT::decode($jwt, SECRET_KEY, array(ALGORITMO));

    // Access is granted. Add code of the operation here 

    include ("../conexion/bd.php");

    $query = "SELECT id_proser, id_prove, codigo_proser, categoria_proser,
    nombre_proser, descripcion_proser, precio_proser, preciosugerido_proser, cantidad_proser, 
    cantidadfinal_proser, IVA_proser, lote_proser
    FROM productos_servicios 
    ORDER BY nombre_proser ASC";
    $get = mysqli_query($con, $query);

    if ($get) {
        $array = array();
        while ($fila = mysqli_fetch_assoc($get)) {	
            $data[] = array_map('utf8_encode', $fila);
        }
    }else{
        $res = array();
    }
    
    $res = $data;


    $data_insert=array(
        "data" => $res,
        "status" => "success",
        "message" => "Request authorized"
    );  

}catch (Exception $e){

    http_response_code(401);

    $data_insert=array(
        //"data" => $data_from_server,
        "jwt" => $jwt,
        "status" => "error",
        "message" => $e->getMessage()
    );
    
}

echo json_encode($data_insert);