<?php

class Usuario {
    private $connect;
    private $table = "usuarios";

    private $identificacion;
    private $nombre;
    private $contrasena;
    private $email;
    private $fk_id_rol;

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
    public function getById($identificacion) {
        try {
            $query = "SELECT * FROM $this->table WHERE identificacion = :identificacion";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':identificacion', $identificacion, PDO::PARAM_INT);
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
    public function crearUsuario($identificacion, $nombre, $contrasena, $email, $fk_id_rol) {
    try {
        if (empty($identificacion) || empty($nombre) || empty($contrasena) || empty($email) || empty($fk_id_rol)) {
            throw new Exception("Todos los campos son obligatorios.");
        }
        $contrasenaHasheada = password_hash($contrasena, PASSWORD_BCRYPT);
        $query = "INSERT INTO $this->table (identificacion, nombre, contrasena, email, fk_id_rol) 
                    VALUES (:identificacion, :nombre, :contrasena, :email, :fk_id_rol)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':identificacion', $identificacion);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':contrasena', $contrasenaHasheada); 
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':fk_id_rol', $fk_id_rol, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return [
                'status' => true,
                'message' => 'Usuario creado exitosamente.'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Error al crear el usuario. Por favor, inténtalo de nuevo.'
            ];
        }
    } catch (PDOException $e) {
        error_log("Error al registrar un usuario: " . $e->getMessage());
        return [
            'status' => false,
            'message' => 'Error en la base de datos: ' . $e->getMessage()
        ];
    } 
}

    // Actualizar un usuario
    public function actualizarUsuario($identificacion, $nombre, $contrasena, $email, $fk_id_rol) {
        try {
            $query = "UPDATE $this->table SET nombre = :nombre, contrasena = :contrasena, email = :email, fk_id_rol = :fk_id_rol WHERE identificacion = :identificacion";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':identificacion', $identificacion, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':fk_id_rol', $fk_id_rol, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar un usuario: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar un usuario
    public function eliminarUsuario($identificacion) {
        try {
            $query = "DELETE FROM $this->table WHERE identificacion = :identificacion";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':identificacion', $identificacion, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar un usuario: " . $e->getMessage());
            return false;
        }
    }
}
