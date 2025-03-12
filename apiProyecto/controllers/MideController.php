<?php 

require_once("./config/dataBase.php");
require_once("./models/Mide.php");

class MideController {
    private $db;
    private $mide;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->mide = new Mide($this->db);
    }

    // Obtener todas las mediciones
    public function getAll() {
        $stmt = $this->mide->getAll();
        $mediciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $mediciones
        ]);
        http_response_code(200);
    }

    // Obtener una medición por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $medicion = $this->mide->getById($id);
            if ($medicion) {
                echo json_encode([
                    "status" => 200,
                    "data" => $medicion
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Medición no encontrada"]);
                http_response_code(404);
            }
        }
    }

    // Crear una nueva medición
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['fk_id_sensor']) || !isset($data['fk_id_era'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->mide->crearMedicion($data['fk_id_sensor'], $data['fk_id_era'])) {
                echo json_encode(["message" => "Medición registrada exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar medición"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar una medición
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['fk_id_sensor']) || !isset($data['fk_id_era'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->mide->actualizarMedicion($id, $data['fk_id_sensor'], $data['fk_id_era'])) {
                echo json_encode(["message" => "Medición actualizada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar medición"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar una medición
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->mide->eliminarMedicion($id)) {
                echo json_encode(["message" => "Medición eliminada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar medición"]);
                http_response_code(500);
            }
        }
    }
}
