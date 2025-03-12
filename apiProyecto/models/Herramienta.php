<?php

class Herramienta {
    private $connect;
    private $table = "herramientas";

    private $id_herramienta;
    private $nombre_h;
    private $fecha_prestamo;
    private $estado;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todas las herramientas
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

    // Obtener una herramienta por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id_herramienta = :id_herramienta";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_herramienta', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al obtener herramienta por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear una nueva herramienta
    public function crearHerramienta($nombre_h, $fecha_prestamo, $estado) {
        try {
            $query = "INSERT INTO $this->table (nombre_h, fecha_prestamo, estado) VALUES (:nombre_h, :fecha_prestamo, :estado)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':nombre_h', $nombre_h);
            $stmt->bindParam(':fecha_prestamo', $fecha_prestamo);
            $stmt->bindParam(':estado', $estado);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar herramienta: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar una herramienta
    public function actualizarHerramienta($id, $nombre_h, $fecha_prestamo, $estado) {
        try {
            $query = "UPDATE $this->table SET nombre_h = :nombre_h, fecha_prestamo = :fecha_prestamo, estado = :estado WHERE id_herramienta = :id_herramienta";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_herramienta', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre_h', $nombre_h);
            $stmt->bindParam(':fecha_prestamo', $fecha_prestamo);
            $stmt->bindParam(':estado', $estado);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar herramienta: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar una herramienta
    public function eliminarHerramienta($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_herramienta = :id_herramienta";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_herramienta', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar herramienta: " . $e->getMessage());
            return false;
        }
    }
}
