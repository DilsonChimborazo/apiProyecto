<?php 

require_once("./config/dataBase.php");
require_once("./models/Cultivo.php");

class CultivoController {
    private $db;
    private $cultivo;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->cultivo = new Cultivo($this->db);
    }

    // Obtener todos los cultivos
    public function getAll() {
        $stmt = $this->cultivo->getAll();
        $cultivos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["status" => 200, "data" => $cultivos]);
        http_response_code(200);
    }

    // Obtener un cultivo por ID
    public function getById($id) {
        $cultivo = $this->cultivo->getById($id);
        if ($cultivo) {
            echo json_encode(["status" => 200, "data" => $cultivo]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Cultivo no encontrado"]);
            http_response_code(404);
        }
    }

    // Crear un cultivo
    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['fecha_plantacion'], $data['nombre_cultivo'], $data['descripcion'], $data['fk_id_especie'], $data['fk_id_semillero'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->cultivo->create($data['fecha_plantacion'], $data['nombre_cultivo'], $data['descripcion'], $data['fk_id_especie'], $data['fk_id_semillero'])) {
            echo json_encode(["message" => "Cultivo registrado exitosamente"]);
            http_response_code(201);
        } else {
            echo json_encode(["message" => "Error al registrar cultivo"]);
            http_response_code(500);
        }
    }

    // Actualizar un cultivo
    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['fecha_plantacion'], $data['nombre_cultivo'], $data['descripcion'], $data['fk_id_especie'], $data['fk_id_semillero'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->cultivo->update($id, $data['fecha_plantacion'], $data['nombre_cultivo'], $data['descripcion'], $data['fk_id_especie'], $data['fk_id_semillero'])) {
            echo json_encode(["message" => "Cultivo actualizado exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al actualizar cultivo"]);
            http_response_code(500);
        }
    }

    // Eliminar un cultivo
    public function delete($id) {
        if ($this->cultivo->delete($id)) {
            echo json_encode(["message" => "Cultivo eliminado exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al eliminar cultivo"]);
            http_response_code(500);
        }
    }
}
