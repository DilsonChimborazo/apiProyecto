<?php

class TipoResiduo {
    private $connect;
    private $table = "tipo_residuos";

    private $id_tipo_residuo;
    private $nombre_residuo;
    private $descripcion;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los tipos de residuos
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

    // Obtener un tipo de residuo por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id_tipo_residuo = :id_tipo_residuo";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_tipo_residuo', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al obtener tipo de residuo por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear un nuevo tipo de residuo
    public function crearTipoResiduo($nombre_residuo, $descripcion) {
        try {
            $query = "INSERT INTO $this->table (nombre_residuo, descripcion) VALUES (:nombre_residuo, :descripcion)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':nombre_residuo', $nombre_residuo);
            $stmt->bindParam(':descripcion', $descripcion);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar un tipo de residuo: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar un tipo de residuo
    public function actualizarTipoResiduo($id, $nombre_residuo, $descripcion) {
        try {
            $query = "UPDATE $this->table SET nombre_residuo = :nombre_residuo, descripcion = :descripcion WHERE id_tipo_residuo = :id_tipo_residuo";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_tipo_residuo', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre_residuo', $nombre_residuo);
            $stmt->bindParam(':descripcion', $descripcion);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar un tipo de residuo: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar un tipo de residuo
    public function eliminarTipoResiduo($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_tipo_residuo = :id_tipo_residuo";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_tipo_residuo', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar un tipo de residuo: " . $e->getMessage());
            return false;
        }
    }
}
