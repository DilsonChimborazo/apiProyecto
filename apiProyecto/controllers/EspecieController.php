<?php 

require_once("./config/dataBase.php");
require_once("./models/Especie.php");

class EspecieController {
    private $db;
    private $especie;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->especie = new Especie($this->db);
    }

    // Obtener todas las especies
    public function getAll() {
        $stmt = $this->especie->getAll();
        $especies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $especies
        ]);
        http_response_code(200);
    }

    // Obtener una especie por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $especie = $this->especie->getById($id);
            if ($especie) {
                echo json_encode([
                    "status" => 200,
                    "data" => $especie
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Especie no encontrada"]);
                http_response_code(404);
            }
        }
    }

    // Crear una nueva especie
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre_comun']) || !isset($data['nombre_cientifico']) || 
                !isset($data['descripcion']) || !isset($data['fk_id_tipo_cultivo'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->especie->crearEspecie($data['nombre_comun'], $data['nombre_cientifico'], 
                                             $data['descripcion'], $data['fk_id_tipo_cultivo'])) {
                echo json_encode(["message" => "Especie registrada exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar la especie"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar una especie
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre_comun']) || !isset($data['nombre_cientifico']) || 
                !isset($data['descripcion']) || !isset($data['fk_id_tipo_cultivo'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->especie->actualizarEspecie($id, $data['nombre_comun'], $data['nombre_cientifico'], 
                                                  $data['descripcion'], $data['fk_id_tipo_cultivo'])) {
                echo json_encode(["message" => "Especie actualizada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar la especie"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar una especie
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->especie->eliminarEspecie($id)) {
                echo json_encode(["message" => "Especie eliminada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar la especie"]);
                http_response_code(500);
            }
        }
    }
}
