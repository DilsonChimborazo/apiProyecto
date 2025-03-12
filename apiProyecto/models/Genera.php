<?php

class Genera {
    private $connect;
    private $table = "genera";

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todas las relaciones de genera
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
            $query = "SELECT * FROM $this->table WHERE id_genera = :id_genera";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_genera', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al obtener relación por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear una nueva relación
    public function createGenera($fk_id_cultivo, $fk_id_produccion) {
        try {
            $query = "INSERT INTO $this->table (fk_id_cultivo, fk_id_produccion) VALUES (:fk_id_cultivo, :fk_id_produccion)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':fk_id_cultivo', $fk_id_cultivo, PDO::PARAM_INT);
            $stmt->bindParam(':fk_id_produccion', $fk_id_produccion, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al crear una relación: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar una relación
    public function updateGenera($id, $fk_id_cultivo, $fk_id_produccion) {
        try {
            $query = "UPDATE $this->table SET fk_id_cultivo = :fk_id_cultivo, fk_id_produccion = :fk_id_produccion WHERE id_genera = :id_genera";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_genera', $id, PDO::PARAM_INT);
            $stmt->bindParam(':fk_id_cultivo', $fk_id_cultivo, PDO::PARAM_INT);
            $stmt->bindParam(':fk_id_produccion', $fk_id_produccion, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar la relación: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar una relación
    public function deleteGenera($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_genera = :id_genera";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_genera', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar la relación: " . $e->getMessage());
            return false;
        }
    }
}
?>
