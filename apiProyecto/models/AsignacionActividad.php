<?php

class AsignacionActividad {
    private $connect;
    private $table = "asignacion_actividad";

    private $id_asignacion_actividad;
    private $fecha;
    private $fk_id_actividad;
    private $fk_identificacion;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id_asignacion_actividad = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($fecha, $fk_id_actividad, $fk_identificacion) {
        $query = "INSERT INTO $this->table (fecha, fk_id_actividad, fk_identificacion) VALUES (:fecha, :fk_id_actividad, :fk_identificacion)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":fecha", $fecha);
        $stmt->bindParam(":fk_id_actividad", $fk_id_actividad, PDO::PARAM_INT);
        $stmt->bindParam(":fk_identificacion", $fk_identificacion, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update($id, $fecha, $fk_id_actividad, $fk_identificacion) {
        $query = "UPDATE $this->table SET fecha = :fecha, fk_id_actividad = :fk_id_actividad, fk_identificacion = :fk_identificacion WHERE id_asignacion_actividad = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":fecha", $fecha);
        $stmt->bindParam(":fk_id_actividad", $fk_id_actividad, PDO::PARAM_INT);
        $stmt->bindParam(":fk_identificacion", $fk_identificacion, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE id_asignacion_actividad = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
