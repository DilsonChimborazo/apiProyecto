<?php

require_once("./config/dataBase.php");
require_once("./models/Venta.php");

class VentaController {
    private $db;
    private $venta;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->venta = new Venta($this->db);
    }

    // Obtener todas las ventas
    public function getAll() {
        $stmt = $this->venta->getAll();
        $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $ventas
        ]);
        http_response_code(200);
    }

    // Obtener una venta por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $venta = $this->venta->getById($id);
            if ($venta) {
                echo json_encode([
                    "status" => 200,
                    "data" => $venta
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Venta no encontrada"]);
                http_response_code(404);
            }
        }
    }

    // Crear una nueva venta
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['fk_id_produccion']) || !isset($data['cantidad']) || 
                !isset($data['precio_unitario']) || !isset($data['fecha_venta'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            $total_venta = $data['cantidad'] * $data['precio_unitario'];

            if ($this->venta->crearVenta($data['fk_id_produccion'], $data['cantidad'], $data['precio_unitario'], $total_venta, $data['fecha_venta'])) {
                echo json_encode(["message" => "Venta registrada exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar la venta"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar una venta
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['fk_id_produccion']) || !isset($data['cantidad']) || 
                !isset($data['precio_unitario']) || !isset($data['fecha_venta'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            $total_venta = $data['cantidad'] * $data['precio_unitario'];

            if ($this->venta->actualizarVenta($id, $data['fk_id_produccion'], $data['cantidad'], $data['precio_unitario'], $total_venta, $data['fecha_venta'])) {
                echo json_encode(["message" => "Venta actualizada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar la venta"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar una venta
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->venta->eliminarVenta($id)) {
                echo json_encode(["message" => "Venta eliminada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar la venta"]);
                http_response_code(500);
            }
        }
    }
}
