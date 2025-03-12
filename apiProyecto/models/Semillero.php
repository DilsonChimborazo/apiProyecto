<?php

class Semillero {
    private $connect;
    private $table = "semilleros";

    private $id_semillero;
    private $nombre_semilla;
    private $fecha_siembra;
    private $fecha_estimada;
    private $cantidad;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los semilleros
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

    // Obtener un semillero por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id_semillero = :id_semillero";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_semillero', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al obtener semillero por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear un nuevo semillero
    public function crearSemillero($nombre_semilla, $fecha_siembra, $fecha_estimada, $cantidad) {
        try {
            $query = "INSERT INTO $this->table (nombre_semilla, fecha_siembra, fecha_estimada, cantidad) 
                      VALUES (:nombre_semilla, :fecha_siembra, :fecha_estimada, :cantidad)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':nombre_semilla', $nombre_semilla);
            $stmt->bindParam(':fecha_siembra', $fecha_siembra);
            $stmt->bindParam(':fecha_estimada', $fecha_estimada);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar un semillero: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar un semillero
    public function actualizarSemillero($id, $nombre_semilla, $fecha_siembra, $fecha_estimada, $cantidad) {
        try {
            $query = "UPDATE $this->table 
                      SET nombre_semilla = :nombre_semilla, fecha_siembra = :fecha_siembra, 
                          fecha_estimada = :fecha_estimada, cantidad = :cantidad 
                      WHERE id_semillero = :id_semillero";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_semillero', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre_semilla', $nombre_semilla);
            $stmt->bindParam(':fecha_siembra', $fecha_siembra);
            $stmt->bindParam(':fecha_estimada', $fecha_estimada);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar un semillero: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar un semillero
    public function eliminarSemillero($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_semillero = :id_semillero";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_semillero', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar un semillero: " . $e->getMessage());
            return false;
        }
    }
}
