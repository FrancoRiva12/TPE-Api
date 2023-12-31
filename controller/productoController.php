<?php

require '../config.php';
require '../models/producto.php';

class ProductoController {
    private $producto;

    public function __construct($pdo) {
        $this->producto = new Producto($pdo);
    }

    public function handleRequest() {
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->handleGet($action);
                break;
            case 'POST':
                $this->handlePost($action);
                break;
            case 'PUT':
                $this->handlePut($action);
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
        }
    }

    private function handleGet($action) {
        switch ($action) {
            case 'productos':
                $this->getProductos();
                break;
            case 'producto':
                $this->getProductoPorId();
                break;
            default:
                http_response_code(404);
                echo json_encode(['error' => 'Endpoint no encontrado']);
        }
    }

    private function getProductos() {
        $orden = isset($_GET['orden']) ? $_GET['orden'] : 'ID';
        $direccion = isset($_GET['direccion']) ? $_GET['direccion'] : 'ASC';

         //validamos que los campos de orden esten correctos
        $allowedFields = ['ID', 'Marca', 'Modelo', 'Descripcion', 'Precio'];
        if (!in_array($orden, $allowedFields)) {
            http_response_code(400);
            echo json_encode(['error' => 'Campo de orden no permitido']);
            return;
        }
        try {
            $productos = $this->producto->obtenerTodos($orden, $direccion);
            echo json_encode($productos);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }

    }

    private function getProductoPorId() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if ($id !== null) {
            $producto = $this->producto->obtenerPorId($id);

            if ($producto) {
                echo json_encode($producto);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Producto no encontrado']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'ID de producto no proporcionado']);
        }
    }

    private function handlePost($action) {
        switch ($action) {
            case 'productos':
                $this->agregarProducto();
                break;
            default:
                http_response_code(404);
                echo json_encode(['error' => 'Endpoint no encontrado']);
        }
    }

    private function agregarProducto() {
        $datos = json_decode(file_get_contents("php://input"), true);

        $rowCount = $this->producto->agregarProducto($datos);

        if ($rowCount > 0) {
            http_response_code(201); // Creado
            echo json_encode(['mensaje' => 'Producto agregado correctamente']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'No se pudo agregar el producto']);
        }
    }

    private function handlePut($action) {
        switch ($action) {
            case 'producto':
                $this->modificarProducto();
                break;
            default:
                http_response_code(404);
                echo json_encode(['error' => 'Endpoint no encontrado']);
        }
    }

    private function modificarProducto() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if ($id !== null) {
            $datos = json_decode(file_get_contents("php://input"), true);

            $rowCount = $this->producto->modificarProducto($id, $datos);

            if ($rowCount > 0) {
                http_response_code(200);
                echo json_encode(['mensaje' => 'Producto modificado correctamente']);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'No se pudo modificar el producto']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'ID de producto no proporcionado']);
        }
    }
}