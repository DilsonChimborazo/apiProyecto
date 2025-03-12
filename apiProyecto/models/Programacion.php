<?php

class Programacion {
    private $connect;
    private $table = "programacion";

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todas las programaciones
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

    // Obtener una programación por ID
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id_programacion = :id_programacion";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id_programacion', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    // Crear una nueva programación
    public function crearProgramacion($estado, $fecha_programada, $duracion, $fk_id_asignacion_actividad, $fk_id_calendario_lunar) {
        $query = "INSERT INTO $this->table (estado, fecha_programada, duracion, fk_id_asignacion_actividad, fk_id_calendario_lunar) 
                  VALUES (:estado, :fecha_programada, :duracion, :fk_id_asignacion_actividad, :fk_id_calendario_lunar)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':fecha_programada', $fecha_programada);
        $stmt->bindParam(':duracion', $duracion, PDO::PARAM_INT);
        $stmt->bindParam(':fk_id_asignacion_actividad', $fk_id_asignacion_actividad, PDO::PARAM_INT);
        $stmt->bindParam(':fk_id_calendario_lunar', $fk_id_calendario_lunar, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Actualizar una programación
    public function actualizarProgramacion($id, $estado, $fecha_programada, $duracion, $fk_id_asignacion_actividad, $fk_id_calendario_lunar) {
        $query = "UPDATE $this->table SET estado = :estado, fecha_programada = :fecha_programada, duracion = :duracion, 
                  fk_id_asignacion_actividad = :fk_id_asignacion_actividad, fk_id_calendario_lunar = :fk_id_calendario_lunar 
                  WHERE id_programacion = :id_programacion";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id_programacion', $id, PDO::PARAM_INT);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':fecha_programada', $fecha_programada);
        $stmt->bindParam(':duracion', $duracion, PDO::PARAM_INT);
        $stmt->bindParam(':fk_id_asignacion_actividad', $fk_id_asignacion_actividad, PDO::PARAM_INT);
        $stmt->bindParam(':fk_id_calendario_lunar', $fk_id_calendario_lunar, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Eliminar una programación
    public function eliminarProgramacion($id) {
        $query = "DELETE FROM $this->table WHERE id_programacion = :id_programacion";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id_programacion', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
