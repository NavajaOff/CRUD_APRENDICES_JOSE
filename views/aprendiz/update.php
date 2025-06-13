<?php
require_once '../../controllers/AprendizController.php';

try {
    $controller = new AprendizController();
    
    // Validar que sea una petición POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    // Obtener el ID del aprendiz
    $id = $_POST['id'] ?? null;
    if (!$id) {
        throw new Exception('ID no proporcionado');
    }

    // Eliminar el ID del array de datos
    $data = $_POST;
    unset($data['id']);

    // Procesar la actualización
    $resultado = $controller->update($id, $data);
    
    header('Location: index.php?status=' . $resultado['status'] . '&message=' . urlencode($resultado['message']));
    exit;

} catch (Exception $e) {
    header('Location: editar.php?id=' . $_POST['id'] . '&status=error&message=' . urlencode($e->getMessage()));
    exit;
}