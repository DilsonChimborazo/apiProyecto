<?php 

require_once("./config/dataBase.php");
require_once("./models/Lote.php");

class LoteController {
    private $db;
    private $lote;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->lote = new Lote($this->db);
    }

    // Obtener todos los lotes
    public function getAll() {
        $stmt = $this->lote->getAll();
        $lotes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $lotes
        ]);
        http_response_code(200);
    }

    // Obtener un lote por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $lote = $this->lote->getById($id);
            if ($lote) {
                echo json_encode([
                    "status" => 200,
                    "data" => $lote
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Lote no encontrado"]);
                http_response_code(404);
            }
        }
    }

    // Crear un lote
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['dimension']) || !isset($data['nombre_lote']) || 
                !isset($data['fk_id_ubicacion']) || !isset($data['estado'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->lote->crearLote($data['dimension'], $data['nombre_lote'], 
                                       $data['fk_id_ubicacion'], $data['estado'])) {
                echo json_encode(["message" => "Lote registrado exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar lote"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar un lote
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['dimension']) || !isset($data['nombre_lote']) || 
                !isset($data['fk_id_ubicacion']) || !isset($data['estado'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->lote->actualizarLote($id, $data['dimension'], $data['nombre_lote'], 
                                            $data['fk_id_ubicacion'], $data['estado'])) {
                echo json_encode(["message" => "Lote actualizado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar lote"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar un lote
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->lote->eliminarLote($id)) {
                echo json_encode(["message" => "Lote eliminado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar lote"]);
                http_response_code(500);
            }
        }
    }
}
