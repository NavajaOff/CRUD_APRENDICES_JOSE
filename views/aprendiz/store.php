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

    // Preparar la respuesta para SweetAlert2
    $response = [
        'icon' => $resultado['status'],
        'title' => $resultado['status'] === 'success' ? '¡Éxito!' : 'Error',
        'text' => $resultado['message']
    ];

    // Guardar la respuesta en sesión para mostrarla después de la redirección
    session_start();
    $_SESSION['alert'] = $response;

    // Redireccionar según el resultado
    header('Location: index.php');
    exit;

} catch (Exception $e) {
    // En caso de error inesperado
    session_start();
    $_SESSION['alert'] = [
        'icon' => 'error',
        'title' => 'Error',
        'text' => $e->getMessage()
    ];
    
    header('Location: crear.php');
    exit;
}
