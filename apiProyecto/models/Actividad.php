<?php

class Actividad {
    private $connect;
    private $table = "actividad";

    private $id_actividad;
    private $nombre_actividad;
    private $descripcion;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todas las actividades
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

    // Obtener una actividad por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id_actividad = :id_actividad";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_actividad', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al obtener actividad por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear una nueva actividad
    public function crearActividad($nombre_actividad, $descripcion) {
        try {
            $query = "INSERT INTO $this->table (nombre_actividad, descripcion) VALUES (:nombre_actividad, :descripcion)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':nombre_actividad', $nombre_actividad);
            $stmt->bindParam(':descripcion', $descripcion);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar una actividad: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar una actividad
    public function actualizarActividad($id, $nombre_actividad, $descripcion) {
        try {
            $query = "UPDATE $this->table SET nombre_actividad = :nombre_actividad, descripcion = :descripcion WHERE id_actividad = :id_actividad";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_actividad', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre_actividad', $nombre_actividad);
            $stmt->bindParam(':descripcion', $descripcion);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar una actividad: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar una actividad
    public function eliminarActividad($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_actividad = :id_actividad";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_actividad', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar una actividad: " . $e->getMessage());
            return false;
        }
    }
}
