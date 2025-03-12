<?php 

require_once("./config/dataBase.php");
require_once("./models/Programacion.php");

class ProgramacionController {
    private $db;
    private $programacion;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConection();
        $this->programacion = new Programacion($this->db);
    }

    // Obtener todas las programaciones
    public function getAll() {
        $stmt = $this->programacion->getAll();
        $programaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => 200, "data" => $programaciones]);
        http_response_code(200);
    }

    // Obtener una programación por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $programacion = $this->programacion->getById($id);
            if ($programacion) {
                echo json_encode(["status" => 200, "data" => $programacion]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Programación no encontrada"]);
                http_response_code(404);
            }
        }
    }

    // Crear una programación
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['estado']) || !isset($data['fecha_programada']) || !isset($data['duracion']) ||
                !isset($data['fk_id_asignacion_actividad']) || !isset($data['fk_id_calendario_lunar'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->programacion->crearProgramacion($data['estado'], $data['fecha_programada'], $data['duracion'], 
                                                        $data['fk_id_asignacion_actividad'], $data['fk_id_calendario_lunar'])) {
                echo json_encode(["message" => "Programación registrada exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar programación"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar una programación
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['estado']) || !isset($data['fecha_programada']) || !isset($data['duracion']) ||
                !isset($data['fk_id_asignacion_actividad']) || !isset($data['fk_id_calendario_lunar'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->programacion->actualizarProgramacion($id, $data['estado'], $data['fecha_programada'], $data['duracion'], 
                                                            $data['fk_id_asignacion_actividad'], $data['fk_id_calendario_lunar'])) {
                echo json_encode(["message" => "Programación actualizada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar programación"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar una programación
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->programacion->eliminarProgramacion($id)) {
                echo json_encode(["message" => "Programación eliminada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar programación"]);
                http_response_code(500);
            }
        }
    }
}
