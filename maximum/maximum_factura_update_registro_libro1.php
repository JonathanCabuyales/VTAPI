<?php

header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../jwt/src/BeforeValidException.php';
require_once '../jwt/src/ExpiredException.php';
require_once '../jwt/src/SignatureInvalidException.php';
require_once '../jwt/src/JWT.php';
use \Firebase\JWT\JWT;

define ('SECRET_KEY', '4956andres.'); // la clave secreta puede ser una cadena aleatoria y mantenerse en secreto para cualquier persona
define ('ALGORITMO', 'HS256'); // Algoritmo utilizado para firmar el token

$jwt = $_GET['token'];
$ids = $_GET['ids'];
// $json = file_get_contents('php://input');
// $jsonCliente = json_decode($json);

// if (!$jsonCliente) {
//     exit("No hay datos para registrar");
// }

  

// echo(gettype($ids));

/* $ids = $jsonCliente->ids;
$token = $jsonCliente->token; */
/* $id_movimiento = $jsonCliente->$ids;
$registrado = $jsonCliente->registrado;

$jwt = $jsonCliente->token; */

try {
    JWT::$leeway = 10;
    $decoded = JWT::decode($jwt, SECRET_KEY, array(ALGORITMO));

    // Access is granted. Add code of the operation here 

    $convertirArray = explode(',', $ids);

    include ("../conexion/bd.php");

    $update = false;

    foreach($convertirArray as $id){
        
        $query = "UPDATE movimiento SET registrado='1' WHERE id_movimiento='$id'";
        $update = mysqli_query($con, $query);
    }

    // var_dump($ids);
    // echo ($ids);

    /* foreach($ids as $id){
        echo $id;
    } */
    $data_insert=array(
        // "data" => $update,
        "status" => "success",
        "message" => "Request authorized",
        "type" => $ids,
        "token" => $jwt
    );

}catch (Exception $e){

    // http_response_code(401);
    // echo $e->getMessage();

    $data_insert=array(
        //"data" => $data_from_server,
        "jwt" => $jwt,
        "status" => "error",
        "message" => $e->getMessage()
    );
    
}

header("Content-Type: application/json; charset=UTF-8");
echo json_encode($data_insert, JSON_UNESCAPED_UNICODE);