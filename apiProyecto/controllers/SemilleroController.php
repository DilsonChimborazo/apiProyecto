<?php 

require_once("./config/dataBase.php");
require_once("./models/Semillero.php");

class SemilleroController {
    private $db;
    private $semillero;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->semillero = new Semillero($this->db);
    }

    // Obtener todos los semilleros
    public function getAll() {
        $stmt = $this->semillero->getAll();
        $semilleros = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $semilleros
        ]);
        http_response_code(200);
    }

    // Obtener un semillero por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $semillero = $this->semillero->getById($id);
            if ($semillero) {
                echo json_encode([
                    "status" => 200,
                    "data" => $semillero
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Semillero no encontrado"]);
                http_response_code(404);
            }
        }
    }

    // Crear un semillero
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre_semilla']) || !isset($data['fecha_siembra']) || 
                !isset($data['fecha_estimada']) || !isset($data['cantidad'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->semillero->crearSemillero($data['nombre_semilla'], $data['fecha_siembra'], $data['fecha_estimada'], $data['cantidad'])) {
                echo json_encode(["message" => "Semillero registrado exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar semillero"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar un semillero
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre_semilla']) || !isset($data['fecha_siembra']) || 
                !isset($data['fecha_estimada']) || !isset($data['cantidad'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->semillero->actualizarSemillero($id, $data['nombre_semilla'], $data['fecha_siembra'], $data['fecha_estimada'], $data['cantidad'])) {
                echo json_encode(["message" => "Semillero actualizado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar semillero"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar un semillero
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->semillero->eliminarSemillero($id)) {
                echo json_encode(["message" => "Semillero eliminado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar semillero"]);
                http_response_code(500);
            }
        }
    }
}
