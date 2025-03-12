<?php 

require_once("./config/dataBase.php");
require_once("./models/Desarrollan.php");

class DesarrollanController {
    private $db;
    private $desarrollan;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->desarrollan = new Desarrollan($this->db);
    }

    // Obtener todas las relaciones
    public function getAll() {
        $stmt = $this->desarrollan->getAll();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $data
        ]);
        http_response_code(200);
    }

    // Obtener una relación por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = $this->desarrollan->getById($id);
            if ($data) {
                echo json_encode([
                    "status" => 200,
                    "data" => $data
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Relación no encontrada"]);
                http_response_code(404);
            }
        }
    }

    // Crear una relación
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['fk_id_cultivo']) || !isset($data['fk_id_pea'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->desarrollan->create($data['fk_id_cultivo'], $data['fk_id_pea'])) {
                echo json_encode(["message" => "Relación registrada exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar la relación"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar una relación
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['fk_id_cultivo']) || !isset($data['fk_id_pea'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->desarrollan->update($id, $data['fk_id_cultivo'], $data['fk_id_pea'])) {
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
            if ($this->desarrollan->delete($id)) {
                echo json_encode(["message" => "Relación eliminada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar la relación"]);
                http_response_code(500);
            }
        }
    }
}
