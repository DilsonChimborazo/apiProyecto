<?php 

require_once("./config/dataBase.php");
require_once("./models/Genera.php");

class GeneraController {
    private $db;
    private $genera;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->genera = new Genera($this->db);
    }

    // Obtener todas las relaciones
    public function getAll() {
        $stmt = $this->genera->getAll();
        $relations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $relations
        ]);
        http_response_code(200);
    }

    // Obtener una relación por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $relation = $this->genera->getById($id);
            if ($relation) {
                echo json_encode([
                    "status" => 200,
                    "data" => $relation
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
            
            if (!isset($data['fk_id_cultivo']) || !isset($data['fk_id_produccion'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->genera->createGenera($data['fk_id_cultivo'], $data['fk_id_produccion'])) {
                echo json_encode(["message" => "Relación creada exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al crear relación"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar una relación
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['fk_id_cultivo']) || !isset($data['fk_id_produccion'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->genera->updateGenera($id, $data['fk_id_cultivo'], $data['fk_id_produccion'])) {
                echo json_encode(["message" => "Relación actualizada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar relación"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar una relación
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->genera->deleteGenera($id)) {
                echo json_encode(["message" => "Relación eliminada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar relación"]);
                http_response_code(500);
            }
        }
    }
}
?>
