<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
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

$jsonProyeccion = json_decode($json);

if (!$jsonProyeccion) {
    exit("No hay datos para registrar");
}

$id_pro = $jsonProyeccion->id_pro;
$actividad = $jsonProyeccion->actividad;
$fechaStart = $jsonProyeccion->fechaStart;
$fechaEnd = $jsonProyeccion->fechaEnd;
$dias = $jsonProyeccion->dias;
$antes = $jsonProyeccion->antes;
$durante = $jsonProyeccion->durante;
$despues = $jsonProyeccion->despues;
$jwt = $jsonProyeccion->token;

try {
    JWT::$leeway = 10;
    $decoded = JWT::decode($jwt, SECRET_KEY, array(ALGORITMO));

    // Access is granted. Add code of the operation here 

    include ("../conexion/bd.php");

    $data=array();
    
    $query = "INSERT INTO proyeccion_actividades_pro (
        id_proyecto,
        descripcion,
        fechaStart,
        fechaEnd,
        dias,
        imgAntes,
        imgDurante,
        imgDespues
        ) 
    VALUES ('$id_pro',
        '$actividad',
        '$fechaStart',
        '$fechaEnd',
        '$dias',
        '$antes',
        '$durante',
        '$despues')";

    $insert = mysqli_query($con, $query);

    if($insert){
        $data_insert=array(
            "data" => $insert,
            "status" => "success",
            "message" => "Actividad guardad correctamente"
        ); 
    } else{
        $data_insert=array(
            "data" => $jsonProyeccion,
            "status" => "error",
            "message" => "No se ha podido insertar intente de nuevo"
        ); 
    }
    
    /* if($insert == true){
        
        $id_pro = mysqli_insert_id($con); 
        
        $queryhoja = "INSERT INTO hojapedido (
        id_pro,
        hojapedido_hoja
        )
        VALUES ('$id_pro','[]')";
        
        $queryactividades = "INSERT INTO actividades (
        id_pro,
        actividades_act)
        VALUES ('$id_pro','[]')";
        
        $inserthoja = mysqli_query($con, $queryhoja);
        $insertacti = mysqli_query($con, $queryactividades);
        
        if($inserthoja && $insertacti){
            
            $insertcreado = true;
        }else{
            $insertcreado = false;
        }
        
    }else{
        $insertcreado = false;
    } */



    

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