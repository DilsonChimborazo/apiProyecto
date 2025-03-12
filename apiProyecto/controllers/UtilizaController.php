<?php 

require_once("./config/dataBase.php");
require_once("./models/Utiliza.php");

class UtilizaController {
    private $db;
    private $utiliza;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->utiliza = new Utiliza($this->db);
    }

    // Obtener todas las relaciones
    public function getAll() {
        $stmt = $this->utiliza->getAll();
        $utilizaList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $utilizaList
        ]);
        http_response_code(200);
    }

    // Obtener una relación por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $utiliza = $this->utiliza->getById($id);
            if ($utiliza) {
                echo json_encode([
                    "status" => 200,
                    "data" => $utiliza
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Relación no encontrada"]);
                http_response_code(404);
            }
        }
    }

    // Crear una nueva relación
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['fk_id_insumo']) || !isset($data['fk_id_asignacion_actividad'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->utiliza->crearUtiliza($data['fk_id_insumo'], $data['fk_id_asignacion_actividad'])) {
                echo json_encode(["message" => "Relación creada exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al crear la relación"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar una relación
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['fk_id_insumo']) || !isset($data['fk_id_asignacion_actividad'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->utiliza->actualizarUtiliza($id, $data['fk_id_insumo'], $data['fk_id_asignacion_actividad'])) {
                echo json_encode(["message" => "Relación actualizada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar la relación"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar una relación
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->utiliza->eliminarUtiliza($id)) {
                echo json_encode(["message" => "Relación eliminada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar la relación"]);
                http_response_code(500);
            }
        }
    }
}
