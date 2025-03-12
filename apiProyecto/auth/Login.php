<?php
require_once __DIR__.'/../config/dataBase.php';
require_once __DIR__.'/../vendor/autoload.php';

use Firebase\JWT\JWT;

$key = "soloyo";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['identificacion']) || !isset($input['contrasena'])) {
    echo json_encode(["error" => "Faltan datos: identificación y contraseña"]);
    exit;
}

$identificacion = $input['identificacion'];
$contrasena = $input['contrasena'];

$database = new DataBase();
$pdo = $database->getConection();

if (!$pdo) {
    echo json_encode(["error" => "Error en la conexión a la base de datos"]);
    exit;
}

$query = "SELECT  identificacion, contrasena FROM usuarios WHERE identificacion = :identificacion";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":identificacion", $identificacion);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($contrasena, $user['contrasena'])) {
    $payload = [
        "identificacion" => $user['identificacion'],
        "exp" => time() + (60 * 60 * 12)
    ];

    $jwt = JWT::encode($payload, $key, 'HS256');

    echo json_encode([
        "message" => "Login exitoso",
        "token" => $jwt
    ]);
} else {
    echo json_encode(["error" => "Credenciales incorrectas"]);
}
?>
