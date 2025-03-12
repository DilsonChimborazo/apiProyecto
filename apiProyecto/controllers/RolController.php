<?php 

require_once("./config/dataBase.php");
require_once("./models/Rol.php");

class RolController {
    private $db;
    private $rol;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->rol = new rol($this->db);
    }

    // Obtener todos los usuarios
    public function getAll() {
        $stmt = $this->rol->getAll();
        $rols = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $rols
        ]);
        http_response_code(200);
    }

    // Obtener un usuario por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $rol = $this->rol->getById($id);
            if ($rol) {
                echo json_encode([
                    "status" => 200,
                    "data" => $rol
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Usuario no encontrado"]);
                http_response_code(404);
            }
        }
    }

    // Crear un usuario
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre_rol']) || !isset($data['fecha_creacion'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->rol->crearUsuario($data['nombre_rol'], $data['fecha_creacion'])) {
                echo json_encode(["message" => "Usuario registrado exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar usuario"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar un usuario
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre_rol']) || !isset($data['fecha_creacion'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->rol->actualizarUsuario($id, $data['nombre_rol'], $data['fecha_creacion'])) {
                echo json_encode(["message" => "Usuario actualizado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar usuario"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar un usuario
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->rol->eliminarUsuario($id)) {
                echo json_encode(["message" => "Usuario eliminado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar usuario"]);
                http_response_code(500);
            }
        }
    }
}
