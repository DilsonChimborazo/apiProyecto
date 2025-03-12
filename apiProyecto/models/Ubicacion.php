<?php

class Ubicacion {
    private $connect;
    private $table = "ubicacion";

    private $id_ubicacion;
    private $latitud;
    private $longitud;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todas las ubicaciones
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

    // Obtener una ubicación por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id_ubicacion = :id_ubicacion";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_ubicacion', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al obtener ubicación por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear una nueva ubicación
    public function crearUbicacion($latitud, $longitud) {
        try {
            $query = "INSERT INTO $this->table (latitud, longitud) VALUES (:latitud, :longitud)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':latitud', $latitud);
            $stmt->bindParam(':longitud', $longitud);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar una ubicación: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar una ubicación
    public function actualizarUbicacion($id, $latitud, $longitud) {
        try {
            $query = "UPDATE $this->table SET latitud = :latitud, longitud = :longitud WHERE id_ubicacion = :id_ubicacion";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_ubicacion', $id, PDO::PARAM_INT);
            $stmt->bindParam(':latitud', $latitud);
            $stmt->bindParam(':longitud', $longitud);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar una ubicación: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar una ubicación
    public function eliminarUbicacion($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_ubicacion = :id_ubicacion";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_ubicacion', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar una ubicación: " . $e->getMessage());
            return false;
        }
    }
}
