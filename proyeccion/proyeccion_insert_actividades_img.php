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

// $json = file_get_contents('php://input');

// $jsonProyeccion = json_decode($json);

// $formData =$_FILES[$jsonProyeccion->formData];
/* 

if (!$jsonProyeccion) {
    exit("No hay datos para registrar");
}
 */
// $jwt = $jsonProyeccion->token;



try {

   
    if(isset($_FILES['img'])){

        // $id = $_POST['id_pro'];

        $number = rand(1,1000);
        $imagen_tipo = $_FILES['img']['type'];
        $nombre_archivo = $number.'_'.$_FILES['img']['name'];
        $directorio = "./img/".$nombre_archivo;

        $movido = move_uploaded_file($_FILES['img']['tmp_name'], $directorio);

        $data=array();
    
        if($movido){

            $data_insert=array(
                "data" => $movido,
                "status" => "success",
                "message" => $nombre_archivo
            );

            
        }else{
            $data_insert=array(
                "data" => $nombre_archivo,
                "status" => "error",
                "message" => "no se ha podido subir el archivo."
            );
        }
    }

    /* $query = "INSERT INTO proyeccion_actividades_pro (id_proyecto, descripcion, fecha, dias, imgAntes, imgDurante, imgDespues)
                VALUES()" */

    // JWT::$leeway = 10;
    // $decoded = JWT::decode($jwt, SECRET_KEY, array(ALGORITMO));

    // Access is granted. Add code of the operation here 

    /* include ("../conexion/bd.php");

     */
    
    /* $query = "INSERT INTO proyeccion_actividades_pro (
        id_proyecto,
        descripcion,
        fecha,
        dias,
        imgAntes,
        imgDurante,
        imgDespues) 
    VALUES ('$id_usuario',
        '$descripcion_pro',
        '$estado_pro',
        '$informacion_pro',
        '$tiempo_pro',
        '$fechas_pro',
        '$viabilidad_pro',
        '$valores_pro',
        '$empleados_pro',
        '$equipo_pro',
        '$insumos_pro',
        '$rendimiento_pro')"; */

    /* $insert = mysqli_query($con, $query);
    
    if($insert == true){
        
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



    /* $data_insert=array(
        "data" => $json,
        "status" => "success",
        "message" => "Request authorized"
    );  */ 

}catch (Exception $e){

    http_response_code(401);

    /* $data_insert=array(
        //"data" => $data_from_server,
        "jwt" => $json,
        "status" => "error",
        "message" => $e->getMessage()
    ); */
    
}

echo json_encode($data_insert);