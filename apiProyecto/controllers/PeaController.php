<?php 

require_once("./config/dataBase.php");
require_once("./models/Pea.php");

class PeaController {
    private $db;
    private $pea;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->pea = new Pea($this->db);
    }

    // Obtener todos los registros
    public function getAll() {
        $stmt = $this->pea->getAll();
        $peas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $peas
        ]);
        http_response_code(200);
    }

    // Obtener un registro por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $pea = $this->pea->getById($id);
            if ($pea) {
                echo json_encode([
                    "status" => 200,
                    "data" => $pea
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Registro no encontrado"]);
                http_response_code(404);
            }
        }
    }

    // Crear un nuevo registro
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre']) || !isset($data['descripcion'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->pea->create($data['nombre'], $data['descripcion'])) {
                echo json_encode(["message" => "Registro creado exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al crear registro"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar un registro
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre']) || !isset($data['descripcion'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->pea->update($id, $data['nombre'], $data['descripcion'])) {
                echo json_encode(["message" => "Registro actualizado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar registro"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar un registro
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->pea->delete($id)) {
                echo json_encode(["message" => "Registro eliminado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar registro"]);
                http_response_code(500);
            }
        }
    }
}
