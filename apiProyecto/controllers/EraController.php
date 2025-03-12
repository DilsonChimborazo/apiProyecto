<?php 

require_once("./config/dataBase.php");
require_once("./models/Era.php");

class EraController {
    private $db;
    private $era;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->era = new Era($this->db);
    }

    // Obtener todas las eras
    public function getAll() {
        $stmt = $this->era->getAll();
        $eras = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $eras
        ]);
        http_response_code(200);
    }

    // Obtener una era por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $era = $this->era->getById($id);
            if ($era) {
                echo json_encode([
                    "status" => 200,
                    "data" => $era
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Era no encontrada"]);
                http_response_code(404);
            }
        }
    }

    // Crear una era
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['descripcion']) || !isset($data['fk_id_lote'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->era->crearEra($data['descripcion'], $data['fk_id_lote'])) {
                echo json_encode(["message" => "Era registrada exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar era"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar una era
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['descripcion']) || !isset($data['fk_id_lote'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->era->actualizarEra($id, $data['descripcion'], $data['fk_id_lote'])) {
                echo json_encode(["message" => "Era actualizada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar era"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar una era
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->era->eliminarEra($id)) {
                echo json_encode(["message" => "Era eliminada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar era"]);
                http_response_code(500);
            }
        }
    }
}
