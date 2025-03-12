<?php

class Cultivo {
    private $connect;
    private $table = "cultivo";

    private $id_cultivo;
    private $fecha_plantacion;
    private $nombre_cultivo;
    private $descripcion;
    private $fk_id_especie;
    private $fk_id_semillero;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los cultivos
    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connect->prepare($query);
        if ($stmt->execute()) {
            return $stmt;
        } else {
            die("Error en la consulta: " . implode(" ", $stmt->errorInfo()));
        }
    }

    // Obtener un cultivo por ID
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id_cultivo = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    // Crear un nuevo cultivo
    public function create($fecha_plantacion, $nombre_cultivo, $descripcion, $fk_id_especie, $fk_id_semillero) {
        $query = "INSERT INTO $this->table (fecha_plantacion, nombre_cultivo, descripcion, fk_id_especie, fk_id_semillero) VALUES (:fecha_plantacion, :nombre_cultivo, :descripcion, :fk_id_especie, :fk_id_semillero)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':fecha_plantacion', $fecha_plantacion);
        $stmt->bindParam(':nombre_cultivo', $nombre_cultivo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fk_id_especie', $fk_id_especie, PDO::PARAM_INT);
        $stmt->bindParam(':fk_id_semillero', $fk_id_semillero, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Actualizar un cultivo
    public function update($id, $fecha_plantacion, $nombre_cultivo, $descripcion, $fk_id_especie, $fk_id_semillero) {
        $query = "UPDATE $this->table SET fecha_plantacion = :fecha_plantacion, nombre_cultivo = :nombre_cultivo, descripcion = :descripcion, fk_id_especie = :fk_id_especie, fk_id_semillero = :fk_id_semillero WHERE id_cultivo = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_plantacion', $fecha_plantacion);
        $stmt->bindParam(':nombre_cultivo', $nombre_cultivo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fk_id_especie', $fk_id_especie, PDO::PARAM_INT);
        $stmt->bindParam(':fk_id_semillero', $fk_id_semillero, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Eliminar un cultivo
    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE id_cultivo = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}