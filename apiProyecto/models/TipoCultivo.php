<?php

class TipoCultivo {
    private $connect;
    private $table = "tipo_cultivo";

    private $id_tipo_cultivo;
    private $nombre;
    private $descripcion;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los tipos de cultivo
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

    // Obtener un tipo de cultivo por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id_tipo_cultivo = :id_tipo_cultivo";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_tipo_cultivo', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al obtener tipo de cultivo por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear un nuevo tipo de cultivo
    public function crearTipoCultivo($nombre, $descripcion) {
        try {
            $query = "INSERT INTO $this->table (nombre, descripcion) VALUES (:nombre, :descripcion)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar un tipo de cultivo: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar un tipo de cultivo
    public function actualizarTipoCultivo($id, $nombre, $descripcion) {
        try {
            $query = "UPDATE $this->table SET nombre = :nombre, descripcion = :descripcion WHERE id_tipo_cultivo = :id_tipo_cultivo";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_tipo_cultivo', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar un tipo de cultivo: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar un tipo de cultivo
    public function eliminarTipoCultivo($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_tipo_cultivo = :id_tipo_cultivo";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_tipo_cultivo', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar un tipo de cultivo: " . $e->getMessage());
            return false;
        }
    }
}
