<?php

class ControlUsaInsumo {
    private $connect;
    private $table = "control_usa_insumo";

    private $id_control_usa_insumo;
    private $fk_id_insumo;
    private $fk_id_control_fitosanitario;
    private $cantidad;

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
            $query = "SELECT * FROM $this->table WHERE id_control_usa_insumo = :id";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
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
    public function create($fk_id_insumo, $fk_id_control_fitosanitario, $cantidad) {
        try {
            $query = "INSERT INTO $this->table (fk_id_insumo, fk_id_control_fitosanitario, cantidad) VALUES (:fk_id_insumo, :fk_id_control_fitosanitario, :cantidad)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':fk_id_insumo', $fk_id_insumo, PDO::PARAM_INT);
            $stmt->bindParam(':fk_id_control_fitosanitario', $fk_id_control_fitosanitario, PDO::PARAM_INT);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar un insumo usado: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar un registro
    public function update($id, $fk_id_insumo, $fk_id_control_fitosanitario, $cantidad) {
        try {
            $query = "UPDATE $this->table SET fk_id_insumo = :fk_id_insumo, fk_id_control_fitosanitario = :fk_id_control_fitosanitario, cantidad = :cantidad WHERE id_control_usa_insumo = :id";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':fk_id_insumo', $fk_id_insumo, PDO::PARAM_INT);
            $stmt->bindParam(':fk_id_control_fitosanitario', $fk_id_control_fitosanitario, PDO::PARAM_INT);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar un insumo usado: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar un registro
    public function delete($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_control_usa_insumo = :id";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar un insumo usado: " . $e->getMessage());
            return false;
        }
    }
}