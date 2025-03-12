<?php

class Era {
    private $connect;
    private $table = "eras";

    private $id_eras;
    private $descripcion;
    private $fk_id_lote;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todas las eras
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

    // Obtener una era por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id_eras = :id_eras";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_eras', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al obtener la era por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear una nueva era
    public function crearEra($descripcion, $fk_id_lote) {
        try {
            $query = "INSERT INTO $this->table (descripcion, fk_id_lote) VALUES (:descripcion, :fk_id_lote)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':fk_id_lote', $fk_id_lote, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar una era: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar una era
    public function actualizarEra($id, $descripcion, $fk_id_lote) {
        try {
            $query = "UPDATE $this->table SET descripcion = :descripcion, fk_id_lote = :fk_id_lote WHERE id_eras = :id_eras";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_eras', $id, PDO::PARAM_INT);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':fk_id_lote', $fk_id_lote, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar una era: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar una era
    public function eliminarEra($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_eras = :id_eras";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_eras', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar una era: " . $e->getMessage());
            return false;
        }
    }
}
