<?php

class Lote {
    private $connect;
    private $table = "lote";

    private $id_lote;
    private $dimension;
    private $nombre_lote;
    private $fk_id_ubicacion;
    private $estado;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los lotes
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

    // Obtener un lote por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id_lote = :id_lote";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_lote', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al obtener lote por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear un nuevo lote
    public function crearLote($dimension, $nombre_lote, $fk_id_ubicacion, $estado) {
        try {
            $query = "INSERT INTO $this->table (dimension, nombre_lote, fk_id_ubicacion, estado) 
                      VALUES (:dimension, :nombre_lote, :fk_id_ubicacion, :estado)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':dimension', $dimension, PDO::PARAM_INT);
            $stmt->bindParam(':nombre_lote', $nombre_lote);
            $stmt->bindParam(':fk_id_ubicacion', $fk_id_ubicacion, PDO::PARAM_INT);
            $stmt->bindParam(':estado', $estado);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar un lote: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar un lote
    public function actualizarLote($id, $dimension, $nombre_lote, $fk_id_ubicacion, $estado) {
        try {
            $query = "UPDATE $this->table SET dimension = :dimension, nombre_lote = :nombre_lote, 
                      fk_id_ubicacion = :fk_id_ubicacion, estado = :estado WHERE id_lote = :id_lote";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_lote', $id, PDO::PARAM_INT);
            $stmt->bindParam(':dimension', $dimension, PDO::PARAM_INT);
            $stmt->bindParam(':nombre_lote', $nombre_lote);
            $stmt->bindParam(':fk_id_ubicacion', $fk_id_ubicacion, PDO::PARAM_INT);
            $stmt->bindParam(':estado', $estado);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar un lote: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar un lote
    public function eliminarLote($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_lote = :id_lote";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_lote', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar un lote: " . $e->getMessage());
            return false;
        }
    }
}
