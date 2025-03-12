<?php

class CalendarioLunar {
    private $connect;
    private $table = "calendario_lunar";

    private $id_calendario_lunar;
    private $fecha;
    private $descripcion_evento;
    private $evento;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los eventos
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

    // Obtener un evento por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id_calendario_lunar = :id";
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
            error_log("Error al obtener evento por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear un nuevo evento
    public function crearEvento($fecha, $descripcion_evento, $evento) {
        try {
            $query = "INSERT INTO $this->table (fecha, descripcion_evento, evento) VALUES (:fecha, :descripcion_evento, :evento)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':descripcion_evento', $descripcion_evento);
            $stmt->bindParam(':evento', $evento);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar un evento: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar un evento
    public function actualizarEvento($id, $fecha, $descripcion_evento, $evento) {
        try {
            $query = "UPDATE $this->table SET fecha = :fecha, descripcion_evento = :descripcion_evento, evento = :evento WHERE id_calendario_lunar = :id";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':descripcion_evento', $descripcion_evento);
            $stmt->bindParam(':evento', $evento);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar un evento: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar un evento
    public function eliminarEvento($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_calendario_lunar = :id";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar un evento: " . $e->getMessage());
            return false;
        }
    }
}
