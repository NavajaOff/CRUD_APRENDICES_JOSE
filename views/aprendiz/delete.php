<?php
require_once '../../controllers/AprendizController.php';

try {
    $controller = new AprendizController();
    
    // Validar que se recibió un ID
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    if (!$id) {
        throw new Exception('ID de aprendiz no válido');
    }

    // Intentar eliminar el aprendiz
    $resultado = $controller->destroy($id);

    if ($resultado['status'] === 'success') {
        header('Location: index.php?status=success&message=' . urlencode('Aprendiz eliminado correctamente'));
    } else {
        header('Location: index.php?status=error&message=' . urlencode($resultado['message']));
    }
    
} catch (Exception $e) {
    header('Location: index.php?status=error&message=' . urlencode('Error al eliminar el aprendiz: ' . $e->getMessage()));
}
exit;
