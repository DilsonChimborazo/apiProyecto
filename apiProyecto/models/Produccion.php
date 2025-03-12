<?php

class Produccion {
    private $connect;
    private $table = "produccion";

    private $id_produccion;
    private $fk_id_cultivo;
    private $cantidad_producida;
    private $fecha_produccion;
    private $fk_id_lote;
    private $descripcion_produccion;
    private $estado;
    private $fecha_cosecha;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todas las producciones
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

    // Obtener una producción por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id_produccion = :id_produccion";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_produccion', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            error_log("Error al obtener producción por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear una nueva producción
    public function crearProduccion($fk_id_cultivo, $cantidad_producida, $fecha_produccion, $fk_id_lote, $descripcion_produccion, $estado, $fecha_cosecha) {
        try {
            $query = "INSERT INTO $this->table (fk_id_cultivo, cantidad_producida, fecha_produccion, fk_id_lote, descripcion_produccion, estado, fecha_cosecha) 
                      VALUES (:fk_id_cultivo, :cantidad_producida, :fecha_produccion, :fk_id_lote, :descripcion_produccion, :estado, :fecha_cosecha)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':fk_id_cultivo', $fk_id_cultivo, PDO::PARAM_INT);
            $stmt->bindParam(':cantidad_producida', $cantidad_producida, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_produccion', $fecha_produccion);
            $stmt->bindParam(':fk_id_lote', $fk_id_lote, PDO::PARAM_INT);
            $stmt->bindParam(':descripcion_produccion', $descripcion_produccion);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':fecha_cosecha', $fecha_cosecha);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al registrar producción: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar una producción
    public function actualizarProduccion($id, $fk_id_cultivo, $cantidad_producida, $fecha_produccion, $fk_id_lote, $descripcion_produccion, $estado, $fecha_cosecha) {
        try {
            $query = "UPDATE $this->table 
                      SET fk_id_cultivo = :fk_id_cultivo, cantidad_producida = :cantidad_producida, fecha_produccion = :fecha_produccion,
                          fk_id_lote = :fk_id_lote, descripcion_produccion = :descripcion_produccion, estado = :estado, fecha_cosecha = :fecha_cosecha 
                      WHERE id_produccion = :id_produccion";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_produccion', $id, PDO::PARAM_INT);
            $stmt->bindParam(':fk_id_cultivo', $fk_id_cultivo, PDO::PARAM_INT);
            $stmt->bindParam(':cantidad_producida', $cantidad_producida, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_produccion', $fecha_produccion);
            $stmt->bindParam(':fk_id_lote', $fk_id_lote, PDO::PARAM_INT);
            $stmt->bindParam(':descripcion_produccion', $descripcion_produccion);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':fecha_cosecha', $fecha_cosecha);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al actualizar producción: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar una producción
    public function eliminarProduccion($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_produccion = :id_produccion";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_produccion', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al eliminar producción: " . $e->getMessage());
            return false;
        }
    }
}
