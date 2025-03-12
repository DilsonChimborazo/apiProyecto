<?php

class Requiere {
    private $connect;
    private $table = "requiere";

    private $id_requiere;
    private $fk_id_herramienta;
    private $fk_id_asignacion_actividad;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los registros
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

    // Obtener un registro por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id_requiere = :id_requiere";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_requiere', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al obtener el registro por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear un nuevo registro
    public function crearRequiere($fk_id_herramienta, $fk_id_asignacion_actividad) {
        try {
            $query = "INSERT INTO $this->table (fk_id_herramienta, fk_id_asignacion_actividad) VALUES (:fk_id_herramienta, :fk_id_asignacion_actividad)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':fk_id_herramienta', $fk_id_herramienta);
            $stmt->bindParam(':fk_id_asignacion_actividad', $fk_id_asignacion_actividad);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar un requiere: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar un registro
    public function eliminarRequiere($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_requiere = :id_requiere";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_requiere', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar un requiere: " . $e->getMessage());
            return false;
        }
    }
}