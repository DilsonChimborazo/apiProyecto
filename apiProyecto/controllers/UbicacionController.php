<?php 

require_once("./config/dataBase.php");
require_once("./models/Ubicacion.php");

class UbicacionController {
    private $db;
    private $ubicacion;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->ubicacion = new Ubicacion($this->db);
    }

    // Obtener todas las ubicaciones
    public function getAll() {
        $stmt = $this->ubicacion->getAll();
        $ubicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $ubicaciones
        ]);
        http_response_code(200);
    }

    // Obtener una ubicación por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $ubicacion = $this->ubicacion->getById($id);
            if ($ubicacion) {
                echo json_encode([
                    "status" => 200,
                    "data" => $ubicacion
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Ubicación no encontrada"]);
                http_response_code(404);
            }
        }
    }

    // Crear una ubicación
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['latitud']) || !isset($data['longitud'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->ubicacion->crearUbicacion($data['latitud'], $data['longitud'])) {
                echo json_encode(["message" => "Ubicación registrada exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar ubicación"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar una ubicación
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['latitud']) || !isset($data['longitud'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->ubicacion->actualizarUbicacion($id, $data['latitud'], $data['longitud'])) {
                echo json_encode(["message" => "Ubicación actualizada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar ubicación"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar una ubicación
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->ubicacion->eliminarUbicacion($id)) {
                echo json_encode(["message" => "Ubicación eliminada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar ubicación"]);
                http_response_code(500);
            }
        }
    }
}
