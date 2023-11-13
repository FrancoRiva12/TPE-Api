<?php

require 'config.php';

// lee accion de la URL
$action = isset($_GET['action']) ? $_GET['action'] : 'home'; // Acción por defecto

// Divide la acción en partes
$params = explode('/', $action);

// Determina qué controlador carga
$controllerFolder = 'controller/';

// obtiene el nombre del controlador
$controllerName = $params[0] ?? 'home';

// Obtiene nombre del metodo
$methodName = $params[1] ?? 'index';

// Incluye el controlador correspondiente
$controllerFile = $controllerFolder . $controllerName . 'Controller.php';

if (file_exists($controllerFile)) {
    require $controllerFile;

    // Instancia el controlador y llama al método
    $controllerClassName = ucfirst($controllerName) . 'Controller';
    $controller = new $controllerClassName($pdo);

    // 
    if (method_exists($controller, $methodName)) {
        $controller->$methodName();
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Método no encontrado']);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Controlador no encontrado']);
}
?>
