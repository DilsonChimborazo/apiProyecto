<?php

class Utiliza {
    private $connect;
    private $table = "utiliza";

    private $id_utiliza;
    private $fk_id_insumo;
    private $fk_id_asignacion_actividad;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todas las relaciones
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

    // Obtener una relación por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id_utiliza = :id_utiliza";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_utiliza', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al obtener utiliza por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear una nueva relación
    public function crearUtiliza($fk_id_insumo, $fk_id_asignacion_actividad) {
        try {
            $query = "INSERT INTO $this->table (fk_id_insumo, fk_id_asignacion_actividad) VALUES (:fk_id_insumo, :fk_id_asignacion_actividad)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':fk_id_insumo', $fk_id_insumo, PDO::PARAM_INT);
            $stmt->bindParam(':fk_id_asignacion_actividad', $fk_id_asignacion_actividad, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar utiliza: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar una relación
    public function actualizarUtiliza($id, $fk_id_insumo, $fk_id_asignacion_actividad) {
        try {
            $query = "UPDATE $this->table SET fk_id_insumo = :fk_id_insumo, fk_id_asignacion_actividad = :fk_id_asignacion_actividad WHERE id_utiliza = :id_utiliza";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_utiliza', $id, PDO::PARAM_INT);
            $stmt->bindParam(':fk_id_insumo', $fk_id_insumo, PDO::PARAM_INT);
            $stmt->bindParam(':fk_id_asignacion_actividad', $fk_id_asignacion_actividad, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar utiliza: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar una relación
    public function eliminarUtiliza($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_utiliza = :id_utiliza";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_utiliza', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar utiliza: " . $e->getMessage());
            return false;
        }
    }
}