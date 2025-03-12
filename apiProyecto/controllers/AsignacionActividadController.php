<?php 

require_once("./config/dataBase.php");
require_once("./models/AsignacionActividad.php");

class AsignacionActividadController {
    private $db;
    private $asignacionActividad;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->asignacionActividad = new AsignacionActividad($this->db);
    }

    // Obtener todas las asignaciones de actividades
    public function getAll() {
        $stmt = $this->asignacionActividad->getAll();
        $asignaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $asignaciones
        ]);
        http_response_code(200);
    }

    // Obtener una asignación de actividad por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $asignacion = $this->asignacionActividad->getById($id);
            if ($asignacion) {
                echo json_encode([
                    "status" => 200,
                    "data" => $asignacion
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Asignación no encontrada"]);
                http_response_code(404);
            }
        }
    }

    // Crear una asignación de actividad
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['fecha']) || !isset($data['fk_id_actividad']) || !isset($data['fk_identificacion'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->asignacionActividad->crearAsignacion($data['fecha'], $data['fk_id_actividad'], $data['fk_identificacion'])) {
                echo json_encode(["message" => "Asignación creada exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al crear la asignación"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar una asignación de actividad
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['fecha']) || !isset($data['fk_id_actividad']) || !isset($data['fk_identificacion'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->asignacionActividad->actualizarAsignacion($id, $data['fecha'], $data['fk_id_actividad'], $data['fk_identificacion'])) {
                echo json_encode(["message" => "Asignación actualizada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar la asignación"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar una asignación de actividad
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->asignacionActividad->eliminarAsignacion($id)) {
                echo json_encode(["message" => "Asignación eliminada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar la asignación"]);
                http_response_code(500);
            }
        }
    }
}
