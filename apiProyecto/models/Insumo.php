<?php

class Insumo {
    private $connect;
    private $table = "insumos";

    private $id_insumo;
    private $nombre;
    private $tipo;
    private $precio_unidad;
    private $cantidad;
    private $unidad_medida;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los insumos
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

    // Obtener un insumo por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id_insumo = :id_insumo";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_insumo', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            return false;
        }
    }

    // Crear un nuevo insumo
    public function crearInsumo($nombre, $tipo, $precio_unidad, $cantidad, $unidad_medida) {
        try {
            $query = "INSERT INTO $this->table (nombre, tipo, precio_unidad, cantidad, unidad_medida) VALUES (:nombre, :tipo, :precio_unidad, :cantidad, :unidad_medida)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':precio_unidad', $precio_unidad, PDO::PARAM_INT);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':unidad_medida', $unidad_medida);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            return false;
        }
    }

    // Actualizar un insumo
    public function actualizarInsumo($id, $nombre, $tipo, $precio_unidad, $cantidad, $unidad_medida) {
        try {
            $query = "UPDATE $this->table SET nombre = :nombre, tipo = :tipo, precio_unidad = :precio_unidad, cantidad = :cantidad, unidad_medida = :unidad_medida WHERE id_insumo = :id_insumo";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_insumo', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':precio_unidad', $precio_unidad, PDO::PARAM_INT);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':unidad_medida', $unidad_medida);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            return false;
        }
    }

    // Eliminar un insumo
    public function eliminarInsumo($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id_insumo = :id_insumo";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_insumo', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            return false;
        }
    }
}
