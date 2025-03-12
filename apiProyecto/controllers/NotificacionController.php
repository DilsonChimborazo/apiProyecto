<?php 

require_once("./config/dataBase.php");
require_once("./models/Notificacion.php");

class NotificacionController {
    private $db;
    private $notificacion;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->notificacion = new Notificacion($this->db);
    }

    // Obtener todas las notificaciones
    public function getAll() {
        $stmt = $this->notificacion->getAll();
        $notificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $notificaciones
        ]);
        http_response_code(200);
    }

    // Obtener una notificación por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $notificacion = $this->notificacion->getById($id);
            if ($notificacion) {
                echo json_encode([
                    "status" => 200,
                    "data" => $notificacion
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Notificación no encontrada"]);
                http_response_code(404);
            }
        }
    }

    // Crear una notificación
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['titulo']) || !isset($data['mensaje']) || !isset($data['fk_id_programacion'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->notificacion->crearNotificacion($data['titulo'], $data['mensaje'], $data['fk_id_programacion'])) {
                echo json_encode(["message" => "Notificación creada exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al crear la notificación"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar una notificación
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['titulo']) || !isset($data['mensaje']) || !isset($data['fk_id_programacion'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->notificacion->actualizarNotificacion($id, $data['titulo'], $data['mensaje'], $data['fk_id_programacion'])) {
                echo json_encode(["message" => "Notificación actualizada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar la notificación"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar una notificación
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->notificacion->eliminarNotificacion($id)) {
                echo json_encode(["message" => "Notificación eliminada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar la notificación"]);
                http_response_code(500);
            }
        }
    }
}

