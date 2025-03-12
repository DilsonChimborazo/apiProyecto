<?php

class Mide {
    private $connect;
    private $table = "mide";

    private $id_mide;
    private $fk_id_sensor;
    private $fk_id_era;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todas las mediciones
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

    // Obtener una medición por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id_mide = :id_mide";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_mide', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al obtener medición por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear una nueva medición
    public function crearMedicion($fk_id_sensor, $fk_id_era) {
        try {
            $query = "INSERT INTO $this->table (fk_id_sensor, fk_id_era) VALUES (:fk_id_sensor, :fk_id_era)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':fk_id_sensor', $fk_id_sensor, PDO::PARAM_INT);
            $stmt->bindParam(':fk_id_era', $fk_id_era, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar medición: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar una medición
    public function actualizarMedicion($id, $fk_id_sensor, $fk_id_era) {
        try {
            $query = "UPDATE $this->table SET fk_id_sensor = :fk_id_sensor, fk_id_era = :fk_id_era WHERE id_mide = :id_mide";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_mide', $id, PDO::PARAM_INT);
            $stmt->bindParam(':fk_id_sensor', $fk_id_sensor, PDO::PARAM_INT);
            $stmt->bindParam(':fk_id_era', $fk_id_era, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar medición: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar una medición
    public function eliminarMedicion($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_mide = :id_mide";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_mide', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar medición: " . $e->getMessage());
            return false;
        }
    }
}
