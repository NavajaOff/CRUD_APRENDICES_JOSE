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
    <div class="card-header bg-info text-white">
        <h4 class="mb-0">
            <i class="fas fa-user"></i> Detalles del Aprendiz
        </h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="border-bottom pb-2">Información Personal</h5>
                <dl class="row">
                    <dt class="col-sm-4">Documento:</dt>
                    <dd class="col-sm-8">
                        <?= $aprendiz['tipo_documento'] ?> - 
                        <?= $aprendiz['numero_documento'] ?>
                    </dd>

                    <dt class="col-sm-4">Nombres:</dt>
                    <dd class="col-sm-8">
                        <?= $aprendiz['primer_nombre'] ?> 
                        <?= $aprendiz['segundo_nombre'] ?>
                    </dd>

                    <dt class="col-sm-4">Apellidos:</dt>
                    <dd class="col-sm-8">
                        <?= $aprendiz['primer_apellido'] ?> 
                        <?= $aprendiz['segundo_apellido'] ?>
                    </dd>

                    <dt class="col-sm-4">Sexo:</dt>
                    <dd class="col-sm-8"><?= $aprendiz['nombre_sexo'] ?></dd>

                    <dt class="col-sm-4">Grupo Sanguíneo:</dt>
                    <dd class="col-sm-8"><?= $aprendiz['grupo_sanguineo'] ?></dd>
                </dl>
            </div>

            <div class="col-md-6">
                <h5 class="border-bottom pb-2">Información Académica</h5>
                <dl class="row">
                    <dt class="col-sm-4">Ficha:</dt>
                    <dd class="col-sm-8"><?= $aprendiz['numero_ficha'] ?></dd>

                    <dt class="col-sm-4">Programa:</dt>
                    <dd class="col-sm-8"><?= $aprendiz['programa_formacion'] ?></dd>

                    <dt class="col-sm-4">Estado:</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-<?= $aprendiz['estado'] === 'Activo' ? 'success' : 'danger' ?>">
                            <?= $aprendiz['estado'] ?>
                        </span>
                    </dd>
                </dl>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="editar.php?id=<?= $aprendiz['id'] ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>

<?php require_once '../head/footer.php'; ?>
