<?php 

require_once("./config/dataBase.php");
require_once("./models/Produccion.php");

class ProduccionController {
    private $db;
    private $produccion;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->produccion = new Produccion($this->db);
    }

    // Obtener todas las producciones
    public function getAll() {
        $stmt = $this->produccion->getAll();
        $producciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["status" => 200, "data" => $producciones]);
        http_response_code(200);
    }

    // Obtener una producción por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $produccion = $this->produccion->getById($id);
            if ($produccion) {
                echo json_encode(["status" => 200, "data" => $produccion]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Producción no encontrada"]);
                http_response_code(404);
            }
        }
    }

    // Crear una producción
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);

            if ($this->produccion->crearProduccion(
                $data['fk_id_cultivo'], $data['cantidad_producida'], $data['fecha_produccion'], 
                $data['fk_id_lote'], $data['descripcion_produccion'], $data['estado'], $data['fecha_cosecha']
            )) {
                echo json_encode(["message" => "Producción registrada exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar producción"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar una producción
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);

            if ($this->produccion->actualizarProduccion($id, 
                $data['fk_id_cultivo'], $data['cantidad_producida'], $data['fecha_produccion'], 
                $data['fk_id_lote'], $data['descripcion_produccion'], $data['estado'], $data['fecha_cosecha']
            )) {
                echo json_encode(["message" => "Producción actualizada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar producción"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar una producción
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->produccion->eliminarProduccion($id)) {
                echo json_encode(["message" => "Producción eliminada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar producción"]);
                http_response_code(500);
            }
        }
    }
}
