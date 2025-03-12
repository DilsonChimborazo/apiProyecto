<?php

class Notificacion {
    private $connect;
    private $table = "notificacion";

    private $id_notificacion;
    private $titulo;
    private $mensaje;
    private $fk_id_programacion;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todas las notificaciones
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

    // Obtener una notificación por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id_notificacion = :id_notificacion";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_notificacion', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al obtener notificación por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear una nueva notificación
    public function crearNotificacion($titulo, $mensaje, $fk_id_programacion) {
        try {
            $query = "INSERT INTO $this->table (titulo, mensaje, fk_id_programacion) VALUES (:titulo, :mensaje, :fk_id_programacion)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':mensaje', $mensaje);
            $stmt->bindParam(':fk_id_programacion', $fk_id_programacion, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar una notificación: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar una notificación
    public function actualizarNotificacion($id, $titulo, $mensaje, $fk_id_programacion) {
        try {
            $query = "UPDATE $this->table SET titulo = :titulo, mensaje = :mensaje, fk_id_programacion = :fk_id_programacion WHERE id_notificacion = :id_notificacion";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_notificacion', $id, PDO::PARAM_INT);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':mensaje', $mensaje);
            $stmt->bindParam(':fk_id_programacion', $fk_id_programacion, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar una notificación: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar una notificación
    public function eliminarNotificacion($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_notificacion = :id_notificacion";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_notificacion', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar una notificación: " . $e->getMessage());
            return false;
        }
    }
}
