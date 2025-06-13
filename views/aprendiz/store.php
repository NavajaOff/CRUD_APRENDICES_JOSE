<?php
require_once '../../controllers/AprendizController.php';

try {
    $controller = new AprendizController();
    
    // Validar que sea una petición POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    // Procesar la solicitud
    $resultado = $controller->store($_POST);
    
    // Redireccionar con parámetros GET
    header('Location: index.php?status=' . $resultado['status'] . '&message=' . urlencode($resultado['message']));
    exit;

} catch (Exception $e) {
    header('Location: crear.php?status=error&message=' . urlencode($e->getMessage()));
    exit;
}
