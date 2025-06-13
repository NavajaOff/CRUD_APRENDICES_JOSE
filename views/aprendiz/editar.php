<?php 
require_once '../../controllers/AprendizController.php';
require_once '../head/head.php';

$controller = new AprendizController();
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

$resultado = $controller->show($id);
if ($resultado['status'] === 'error') {
    header('Location: index.php');
    exit;
}

$aprendiz = $resultado['data'];
?>

<div class="card shadow">
    <div class="card-header bg-warning">
        <h4 class="mb-0"><i class="fas fa-edit"></i> Editar Aprendiz</h4>
    </div>
    <div class="card-body">
        <form action="update.php" method="POST" class="needs-validation" novalidate>
            <input type="hidden" name="id" value="<?= $aprendiz['id'] ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tipo de Documento</label>
                    <select name="tipo_documento_id" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <!-- Agregar opciones dinámicamente con el valor seleccionado -->
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save"></i> Actualizar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
})()
</script>

<?php require_once '../head/footer.php'; ?>