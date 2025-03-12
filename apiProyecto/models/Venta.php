<?php

class Venta {
    private $connect;
    private $table = "venta";

    private $id_venta;
    private $fk_id_produccion;
    private $cantidad;
    private $precio_unitario;
    private $total_venta;
    private $fecha_venta;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todas las ventas
    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connect->prepare($query);
        if ($stmt->execute()) {
            return $stmt;
        } else {
            $error = $stmt->errorInfo();
            die("Error en la consulta de la DB: " . $error[2]);
        }
    }

    // Obtener una venta por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id_venta = :id_venta";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_venta', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al obtener venta por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear una nueva venta
    public function crearVenta($fk_id_produccion, $cantidad, $precio_unitario, $fecha_venta) {
        try {
            $total_venta = $cantidad * $precio_unitario;
            $query = "INSERT INTO $this->table (fk_id_produccion, cantidad, precio_unitario, total_venta, fecha_venta) 
                      VALUES (:fk_id_produccion, :cantidad, :precio_unitario, :total_venta, :fecha_venta)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':fk_id_produccion', $fk_id_produccion, PDO::PARAM_INT);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':precio_unitario', $precio_unitario, PDO::PARAM_INT);
            $stmt->bindParam(':total_venta', $total_venta, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_venta', $fecha_venta);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar una venta: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar una venta
    public function actualizarVenta($id, $fk_id_produccion, $cantidad, $precio_unitario, $fecha_venta) {
        try {
            $total_venta = $cantidad * $precio_unitario;
            $query = "UPDATE $this->table SET fk_id_produccion = :fk_id_produccion, cantidad = :cantidad, 
                      precio_unitario = :precio_unitario, total_venta = :total_venta, fecha_venta = :fecha_venta 
                      WHERE id_venta = :id_venta";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_venta', $id, PDO::PARAM_INT);
            $stmt->bindParam(':fk_id_produccion', $fk_id_produccion, PDO::PARAM_INT);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':precio_unitario', $precio_unitario, PDO::PARAM_INT);
            $stmt->bindParam(':total_venta', $total_venta, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_venta', $fecha_venta);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar una venta: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar una venta
    public function eliminarVenta($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_venta = :id_venta";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_venta', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar una venta: " . $e->getMessage());
            return false;
        }
    }
}