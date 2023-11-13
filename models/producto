<?php

require './config.php';

class Producto {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerTodos($orden = 'ID', $direccion = 'ASC') {
        //validamos campo de orden
        $allowedFields = ['ID', 'Marca', 'Modelo', 'Descripcion', 'Precio'];
        if (!in_array($orden, $allowedFields)) {
            throw new Exception('Campo de orden no permitido');
        }

        try {
            $stmt = $this->pdo->prepare("SELECT * FROM producto ORDER BY $orden $direccion");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception('Error al obtener productos: ' . $e->getMessage());
        }
    }

    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM producto WHERE ID = ?");
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function agregarProducto($datos) {
        $stmt = $this->pdo->prepare("INSERT INTO producto (Marca, Modelo, Descripcion, Precio) VALUES (?, ?, ?, ?)");
        $stmt->execute([$datos['Marca'], $datos['Modelo'], $datos['Descripcion'], $datos['Precio']]);

        return $stmt->rowCount();
    }

    public function modificarProducto($id, $datos) {
        $stmt = $this->pdo->prepare("UPDATE producto SET Marca = ?, Modelo = ?, Descripcion = ?, Precio = ? WHERE ID = ?");
        $stmt->execute([$datos['Marca'], $datos['Modelo'], $datos['Descripcion'], $datos['Precio'], $id]);

        return $stmt->rowCount();
    }
}