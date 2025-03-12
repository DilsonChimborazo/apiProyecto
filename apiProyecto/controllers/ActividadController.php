<?php 

require_once("./config/dataBase.php");
require_once("./models/Actividad.php");

class ActividadController {
    private $db;
    private $actividad;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->actividad = new Actividad($this->db);
    }

    // Obtener todas las actividades
    public function getAll() {
        $stmt = $this->actividad->getAll();
        $actividades = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $actividades
        ]);
        http_response_code(200);
    }

    // Obtener una actividad por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $actividad = $this->actividad->getById($id);
            if ($actividad) {
                echo json_encode([
                    "status" => 200,
                    "data" => $actividad
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Actividad no encontrada"]);
                http_response_code(404);
            }
        }
    }

    // Crear una actividad
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre_actividad']) || !isset($data['descripcion'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->actividad->crearActividad($data['nombre_actividad'], $data['descripcion'])) {
                echo json_encode(["message" => "Actividad registrada exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar actividad"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar una actividad
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre_actividad']) || !isset($data['descripcion'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->actividad->actualizarActividad($id, $data['nombre_actividad'], $data['descripcion'])) {
                echo json_encode(["message" => "Actividad actualizada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar actividad"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar una actividad
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->actividad->eliminarActividad($id)) {
                echo json_encode(["message" => "Actividad eliminada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar actividad"]);
                http_response_code(500);
            }
        }
    }
}

