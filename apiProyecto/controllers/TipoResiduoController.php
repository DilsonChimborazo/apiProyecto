<?php 

require_once("./config/dataBase.php");
require_once("./models/TipoResiduo.php");

class TipoResiduoController {
    private $db;
    private $tipoResiduo;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->tipoResiduo = new TipoResiduo($this->db);
    }

    // Obtener todos los tipos de residuos
    public function getAll() {
        $stmt = $this->tipoResiduo->getAll();
        $residuos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $residuos
        ]);
        http_response_code(200);
    }

    // Obtener un tipo de residuo por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $residuo = $this->tipoResiduo->getById($id);
            if ($residuo) {
                echo json_encode([
                    "status" => 200,
                    "data" => $residuo
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Tipo de residuo no encontrado"]);
                http_response_code(404);
            }
        }
    }

    // Crear un tipo de residuo
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre_residuo']) || !isset($data['descripcion'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->tipoResiduo->crearTipoResiduo($data['nombre_residuo'], $data['descripcion'])) {
                echo json_encode(["message" => "Tipo de residuo registrado exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar tipo de residuo"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar un tipo de residuo
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre_residuo']) || !isset($data['descripcion'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->tipoResiduo->actualizarTipoResiduo($id, $data['nombre_residuo'], $data['descripcion'])) {
                echo json_encode(["message" => "Tipo de residuo actualizado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar tipo de residuo"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar un tipo de residuo
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->tipoResiduo->eliminarTipoResiduo($id)) {
                echo json_encode(["message" => "Tipo de residuo eliminado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar tipo de residuo"]);
                http_response_code(500);
            }
        }
    }
}
