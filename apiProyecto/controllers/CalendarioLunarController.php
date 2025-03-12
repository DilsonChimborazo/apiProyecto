<?php
require_once("./config/dataBase.php");
require_once("./models/CalendarioLunar.php");

class CalendarioLunarController {
    private $db;
    private $calendario;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->calendario = new CalendarioLunar($this->db);
    }

    public function getAll() {
        $stmt = $this->calendario->getAll();
        $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => 200, "data" => $eventos]);
        http_response_code(200);
    }

    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $evento = $this->calendario->getById($id);
            if ($evento) {
                echo json_encode(["status" => 200, "data" => $evento]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Evento no encontrado"]);
                http_response_code(404);
            }
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['fecha']) || !isset($data['descripcion_evento']) || !isset($data['evento'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }
            if ($this->calendario->crearEvento($data['fecha'], $data['descripcion_evento'], $data['evento'])) {
                echo json_encode(["message" => "Evento registrado exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar evento"]);
                http_response_code(500);
            }
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['fecha']) || !isset($data['descripcion_evento']) || !isset($data['evento'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }
            if ($this->calendario->actualizarEvento($id, $data['fecha'], $data['descripcion_evento'], $data['evento'])) {
                echo json_encode(["message" => "Evento actualizado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar evento"]);
                http_response_code(500);
            }
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->calendario->eliminarEvento($id)) {
                echo json_encode(["message" => "Evento eliminado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar evento"]);
                http_response_code(500);
            }
        }
    }
}
