<?php 

require_once("./config/dataBase.php");
require_once("./models/Herramienta.php");

class HerramientaController {
    private $db;
    private $herramienta;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->herramienta = new Herramienta($this->db);
    }

    // Obtener todas las herramientas
    public function getAll() {
        $stmt = $this->herramienta->getAll();
        $herramientas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $herramientas
        ]);
        http_response_code(200);
    }

    // Obtener una herramienta por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $herramienta = $this->herramienta->getById($id);
            if ($herramienta) {
                echo json_encode([
                    "status" => 200,
                    "data" => $herramienta
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Herramienta no encontrada"]);
                http_response_code(404);
            }
        }
    }

    // Crear una herramienta
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre_h']) || !isset($data['fecha_prestamo']) || !isset($data['estado'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->herramienta->crearHerramienta($data['nombre_h'], $data['fecha_prestamo'], $data['estado'])) {
                echo json_encode(["message" => "Herramienta registrada exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar herramienta"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar una herramienta
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre_h']) || !isset($data['fecha_prestamo']) || !isset($data['estado'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->herramienta->actualizarHerramienta($id, $data['nombre_h'], $data['fecha_prestamo'], $data['estado'])) {
                echo json_encode(["message" => "Herramienta actualizada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar herramienta"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar una herramienta
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->herramienta->eliminarHerramienta($id)) {
                echo json_encode(["message" => "Herramienta eliminada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar herramienta"]);
                http_response_code(500);
            }
        }
    }
}
