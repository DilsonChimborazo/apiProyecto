<?php 

require_once("./config/dataBase.php");
require_once("./models/Sensor.php");

class SensorController {
    private $db;
    private $sensor;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->sensor = new Sensor($this->db);
    }

    // Obtener todos los sensores
    public function getAll() {
        $stmt = $this->sensor->getAll();
        $sensores = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $sensores
        ]);
        http_response_code(200);
    }

    // Obtener un sensor por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $sensor = $this->sensor->getById($id);
            if ($sensor) {
                echo json_encode([
                    "status" => 200,
                    "data" => $sensor
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Sensor no encontrado"]);
                http_response_code(404);
            }
        }
    }

    // Crear un sensor
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre_sensor']) || !isset($data['tipo_sensor']) || !isset($data['unidad_medida']) || 
                !isset($data['descripcion']) || !isset($data['medida_minima']) || !isset($data['medida_maxima'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->sensor->crearSensor($data['nombre_sensor'], $data['tipo_sensor'], $data['unidad_medida'], 
                                           $data['descripcion'], $data['medida_minima'], $data['medida_maxima'])) {
                echo json_encode(["message" => "Sensor registrado exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar sensor"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar un sensor
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre_sensor']) || !isset($data['tipo_sensor']) || !isset($data['unidad_medida']) || 
                !isset($data['descripcion']) || !isset($data['medida_minima']) || !isset($data['medida_maxima'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->sensor->actualizarSensor($id, $data['nombre_sensor'], $data['tipo_sensor'], $data['unidad_medida'], 
                                                $data['descripcion'], $data['medida_minima'], $data['medida_maxima'])) {
                echo json_encode(["message" => "Sensor actualizado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar sensor"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar un sensor
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->sensor->eliminarSensor($id)) {
                echo json_encode(["message" => "Sensor eliminado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar sensor"]);
                http_response_code(500);
            }
        }
    }
}
