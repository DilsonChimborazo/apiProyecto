<?php 

require_once("./config/dataBase.php");
require_once("./models/TipoCultivo.php");

class TipoCultivoController {
    private $db;
    private $tipoCultivo;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->tipoCultivo = new TipoCultivo($this->db);
    }

    // Obtener todos los tipos de cultivo
    public function getAll() {
        $stmt = $this->tipoCultivo->getAll();
        $tiposCultivo = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $tiposCultivo
        ]);
        http_response_code(200);
    }

    // Obtener un tipo de cultivo por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $tipoCultivo = $this->tipoCultivo->getById($id);
            if ($tipoCultivo) {
                echo json_encode([
                    "status" => 200,
                    "data" => $tipoCultivo
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Tipo de cultivo no encontrado"]);
                http_response_code(404);
            }
        }
    }

    // Crear un tipo de cultivo
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre']) || !isset($data['descripcion'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->tipoCultivo->crearTipoCultivo($data['nombre'], $data['descripcion'])) {
                echo json_encode(["message" => "Tipo de cultivo registrado exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar tipo de cultivo"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar un tipo de cultivo
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre']) || !isset($data['descripcion'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->tipoCultivo->actualizarTipoCultivo($id, $data['nombre'], $data['descripcion'])) {
                echo json_encode(["message" => "Tipo de cultivo actualizado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar tipo de cultivo"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar un tipo de cultivo
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->tipoCultivo->eliminarTipoCultivo($id)) {
                echo json_encode(["message" => "Tipo de cultivo eliminado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar tipo de cultivo"]);
                http_response_code(500);
            }
        }
    }
}
