<?php 

require_once("./config/dataBase.php");
require_once("./models/Usuario.php");

class UsuarioController {
    private $db;
    private $usuario;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->usuario = new Usuario($this->db);
    }

    public function getAll() {
        $stmt = $this->usuario->getAll();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $usuarios
        ]);
        http_response_code(200);
    }

    public function getById($identificacion) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $usuario = $this->usuario->getById($identificacion);
            if ($usuario) {
                echo json_encode([
                    "status" => 200,
                    "data" => $usuario
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Usuario no encontrado"]);
                http_response_code(404);
            }
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['identificacion']) || !isset($data['nombre']) || !isset($data['contrasena']) || !isset($data['email']) || !isset($data['fk_id_rol'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->usuario->crearUsuario($data['identificacion'], $data['nombre'], $data['contrasena'], $data['email'], $data['fk_id_rol'])) {
                echo json_encode(["message" => "Usuario registrado exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar usuario"]);
                http_response_code(500);
            }
        }
    }

    public function update($identificacion) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre']) || !isset($data['contrasena']) || !isset($data['email']) || !isset($data['fk_id_rol'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->usuario->actualizarUsuario($identificacion, $data['nombre'], $data['contrasena'], $data['email'], $data['fk_id_rol'])) {
                echo json_encode(["message" => "Usuario actualizado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar usuario"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar un usuario
    public function delete($identificacion) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->usuario->eliminarUsuario($identificacion)) {
                echo json_encode(["message" => "Usuario eliminado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar usuario"]);
                http_response_code(500);
            }
        }
    }
}
