<?php

class ControlFitosanitario {
    private $connect;
    private $table = "control_fitosanitario";

    private $id_control_fitosanitario;
    private $fecha_control;
    private $descripcion;
    private $fk_id_desarrollan;

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
            $query = "SELECT * FROM $this->table WHERE id_control_fitosanitario = :id";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            error_log("Error al obtener el registro: " . $e->getMessage());
            return false;
        }
    }

    // Crear un nuevo registro
    public function create($fecha_control, $descripcion, $fk_id_desarrollan) {
        try {
            $query = "INSERT INTO $this->table (fecha_control, descripcion, fk_id_desarrollan) 
                      VALUES (:fecha_control, :descripcion, :fk_id_desarrollan)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':fecha_control', $fecha_control);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':fk_id_desarrollan', $fk_id_desarrollan, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al crear el registro: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar un registro
    public function update($id, $fecha_control, $descripcion, $fk_id_desarrollan) {
        try {
            $query = "UPDATE $this->table 
                      SET fecha_control = :fecha_control, descripcion = :descripcion, fk_id_desarrollan = :fk_id_desarrollan 
                      WHERE id_control_fitosanitario = :id";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_control', $fecha_control);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':fk_id_desarrollan', $fk_id_desarrollan, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al actualizar el registro: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar un registro
    public function delete($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_control_fitosanitario = :id";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al eliminar el registro: " . $e->getMessage());
            return false;
        }
    }
}
