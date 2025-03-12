<?php

require_once './vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = "soloyo";
$requestUri = explode('/',$_SERVER['REQUEST_URI']);

if (($requestUri[2]) == "auth") {
    require 'auth/login.php';
    exit;
}

$headers = function_exists('apache_request_headers') ? apache_request_headers() : getallheaders();

if (isset($headers['Authorization'])) {
    $authHeader = $headers['Authorization'];

    if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];

        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            // Controlador e Id (de existir) respectivamente
            $resource = isset($requestUri[2]) ? ucfirst($requestUri[2]) . 'Controller' : null;
            $id = isset($requestUri[3]) ? intval($requestUri[3]) : null;

            // Búsqueda del controlador

            $file = __DIR__."\\controllers\\".$resource.".php";
            if(!file_exists($file)){
                die("Controlador no encontrado");
            }
            else{
                require_once $file;
            }

            $action = $_SERVER['REQUEST_METHOD'];
            echo "Controlador encontrado: " . $resource; 
            $controller = new $resource();
            switch ($action) {
                case "GET":
                    $id ? $controller->getById($id) : $controller->getAll();
                    break;
                case "POST":
                    $controller->create();  
                    break;
                case "PUT":
                    $id ? $controller->update($id) : errorResponse("ID requerido para actualizar", 400);
                    break;
                case "DELETE":
                    $id ? $controller->delete($id, ) : errorResponse("ID requerido para eliminar", 400);
                    break;
                case "DELETE":
                    $identificacion ? $controller->delete($identificacion, ) : errorResponse("ID requerido para eliminar", 400);
                    break;
                default:
                    errorResponse("Método no permitido", 405);
                    break;
            }

        } catch (Exception $e) {
            errorResponse("Token inválido: " . $e->getMessage(), 401);
        }
    } else {
        errorResponse("Formato de token incorrecto. Debe ser: 'Bearer <token>'", 400);
    }
} else {
    errorResponse("Token no proporcionado", 401);
}

function errorResponse($message, $statusCode) {
    http_response_code($statusCode);
    echo json_encode(["error" => $message]);
}
