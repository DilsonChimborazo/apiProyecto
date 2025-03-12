<?php

class Sensor {
    private $connect;
    private $table = "sensores";

    private $id_sensor;
    private $nombre_sensor;
    private $tipo_sensor;
    private $unidad_medida;
    private $descripcion;
    private $medida_minima;
    private $medida_maxima;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los sensores
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

    // Obtener un sensor por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id_sensor = :id_sensor";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_sensor', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al obtener sensor por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear un nuevo sensor
    public function crearSensor($nombre, $tipo, $unidad, $descripcion, $min, $max) {
        try {
            $query = "INSERT INTO $this->table (nombre_sensor, tipo_sensor, unidad_medida, descripcion, medida_minima, medida_maxima) 
                      VALUES (:nombre_sensor, :tipo_sensor, :unidad_medida, :descripcion, :medida_minima, :medida_maxima)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':nombre_sensor', $nombre);
            $stmt->bindParam(':tipo_sensor', $tipo);
            $stmt->bindParam(':unidad_medida', $unidad);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':medida_minima', $min);
            $stmt->bindParam(':medida_maxima', $max);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar un sensor: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar un sensor
    public function actualizarSensor($id, $nombre, $tipo, $unidad, $descripcion, $min, $max) {
        try {
            $query = "UPDATE $this->table SET 
                        nombre_sensor = :nombre_sensor, 
                        tipo_sensor = :tipo_sensor, 
                        unidad_medida = :unidad_medida, 
                        descripcion = :descripcion, 
                        medida_minima = :medida_minima, 
                        medida_maxima = :medida_maxima 
                      WHERE id_sensor = :id_sensor";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_sensor', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre_sensor', $nombre);
            $stmt->bindParam(':tipo_sensor', $tipo);
            $stmt->bindParam(':unidad_medida', $unidad);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':medida_minima', $min);
            $stmt->bindParam(':medida_maxima', $max);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar un sensor: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar un sensor
    public function eliminarSensor($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_sensor = :id_sensor";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_sensor', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar un sensor: " . $e->getMessage());
            return false;
        }
    }
}
