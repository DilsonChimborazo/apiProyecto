<?php 

require_once("./config/dataBase.php");
require_once("./models/Residuo.php");

class ResiduoController {
    private $db;
    private $residuo;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->residuo = new Residuo($this->db);
    }

    // Obtener todos los residuos
    public function getAll() {
        $stmt = $this->residuo->getAll();
        $residuos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $residuos
        ]);
        http_response_code(200);
    }

    // Obtener un residuo por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $residuo = $this->residuo->getById($id);
            if ($residuo) {
                echo json_encode([
                    "status" => 200,
                    "data" => $residuo
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Residuo no encontrado"]);
                http_response_code(404);
            }
        }
    }

    // Crear un residuo
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre']) || !isset($data['fecha']) || !isset($data['descripcion']) || !isset($data['fk_id_tipo_residuo']) || !isset($data['fk_id_cultivo'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->residuo->crearResiduo($data['nombre'], $data['fecha'], $data['descripcion'], $data['fk_id_tipo_residuo'], $data['fk_id_cultivo'])) {
                echo json_encode(["message" => "Residuo registrado exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar residuo"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar un residuo
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre']) || !isset($data['fecha']) || !isset($data['descripcion']) || !isset($data['fk_id_tipo_residuo']) || !isset($data['fk_id_cultivo'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->residuo->actualizarResiduo($id, $data['nombre'], $data['fecha'], $data['descripcion'], $data['fk_id_tipo_residuo'], $data['fk_id_cultivo'])) {
                echo json_encode(["message" => "Residuo actualizado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar residuo"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar un residuo
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->residuo->eliminarResiduo($id)) {
                echo json_encode(["message" => "Residuo eliminado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar residuo"]);
                http_response_code(500);
            }
        }
    }
}
