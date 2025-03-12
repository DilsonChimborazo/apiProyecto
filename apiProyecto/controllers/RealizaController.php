<?php 

require_once("./config/dataBase.php");
require_once("./models/Realiza.php");

class RealizaController {
    private $db;
    private $realiza;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->realiza = new Realiza($this->db);
    }

    // Obtener todos los registros
    public function getAll() {
        $stmt = $this->realiza->getAll();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode([
            "status" => 200,
            "data" => $data
        ]);
        http_response_code(200);
    }

    // Obtener un registro por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = $this->realiza->getById($id);
            if ($data) {
                echo json_encode(["status" => 200, "data" => $data]);
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
            
            if (!isset($data['fk_id_cultivo']) || !isset($data['fk_id_actividad'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->realiza->create($data['fk_id_cultivo'], $data['fk_id_actividad'])) {
                echo json_encode(["message" => "Registro creado exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al crear el registro"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar un registro
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['fk_id_cultivo']) || !isset($data['fk_id_actividad'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->realiza->update($id, $data['fk_id_cultivo'], $data['fk_id_actividad'])) {
                echo json_encode(["message" => "Registro actualizado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar el registro"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar un registro
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->realiza->delete($id)) {
                echo json_encode(["message" => "Registro eliminado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar el registro"]);
                http_response_code(500);
            }
        }
    }
}
