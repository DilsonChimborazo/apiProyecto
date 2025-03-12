<?php

class Realiza {
    private $connect;
    private $table = "realiza";

    private $id_realiza;
    private $fk_id_cultivo;
    private $fk_id_actividad;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todas las relaciones realiza
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
            $query = "SELECT * FROM $this->table WHERE id_realiza = :id_realiza";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_realiza', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al obtener registro por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear un nuevo registro
    public function create($fk_id_cultivo, $fk_id_actividad) {
        try {
            $query = "INSERT INTO $this->table (fk_id_cultivo, fk_id_actividad) VALUES (:fk_id_cultivo, :fk_id_actividad)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':fk_id_cultivo', $fk_id_cultivo);
            $stmt->bindParam(':fk_id_actividad', $fk_id_actividad);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar una relación: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar un registro
    public function update($id, $fk_id_cultivo, $fk_id_actividad) {
        try {
            $query = "UPDATE $this->table SET fk_id_cultivo = :fk_id_cultivo, fk_id_actividad = :fk_id_actividad WHERE id_realiza = :id_realiza";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_realiza', $id, PDO::PARAM_INT);
            $stmt->bindParam(':fk_id_cultivo', $fk_id_cultivo);
            $stmt->bindParam(':fk_id_actividad', $fk_id_actividad);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar un registro: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar un registro
    public function delete($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_realiza = :id_realiza";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_realiza', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar un registro: " . $e->getMessage());
            return false;
        }
    }
}
