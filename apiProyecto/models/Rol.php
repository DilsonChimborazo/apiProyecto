<?php

class Rol {
    private $connect;
    private $table = "rol";

    private $id_rol;
    private $nombre_rol;
    private $fecha_creacion;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los usuarios
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

    // Obtener un usuario por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id_rol = :id_rol";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_rol', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al obtener usuario por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear un nuevo usuario
    public function crearUsuario($nombre_rol, $fecha_creacion) {
        try {
            $query = "INSERT INTO $this->table (nombre_rol, fecha_creacion) VALUES (:nombre_rol, :fecha_creacion)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':nombre_rol', $nombre_rol);
            $stmt->bindParam(':fecha_creacion', $fecha_creacion);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar un usuario: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar un usuario
    public function actualizarUsuario($id, $nombre_rol, $fecha_creacion) {
        try {
            $query = "UPDATE $this->table SET nombre_rol = :nombre_rol, fecha_creacion = :fecha_creacion WHERE id_rol = :id_rol";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_rol', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre_rol', $nombre_rol);
            $stmt->bindParam(':fecha_creacion', $fecha_creacion);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar un usuario: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar un usuario
    public function eliminarUsuario($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_rol = :id_rol";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_rol', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar un usuario: " . $e->getMessage());
            return false;
        }
    }
}
