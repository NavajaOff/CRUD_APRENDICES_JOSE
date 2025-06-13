<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> NVJ || Edit </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="container-fluid">
            <div class="row">
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>

<?php 
require_once '../../controllers/AprendizController.php';
require_once '../head/head.php';

$controller = new AprendizController();
$datosFormulario = $controller->getDatosFormulario();
$datos = $datosFormulario['data'] ?? [];
?>

<div class="card shadow">
    <div class="card-header bg-success text-white">
        <h4 class="mb-0"><i class="fas fa-user-plus"></i> Registrar Nuevo Aprendiz</h4>
    </div>
    <div class="card-body">
        <form action="store.php" method="POST" class="needs-validation" novalidate>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tipo de Documento</label>
                    <select name="tipo_documento_id" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <?php foreach ($datos['tipos_documento'] ?? [] as $tipo): ?>
                            <option value="<?= $tipo['id'] ?>"><?= $tipo['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Seleccione el tipo de documento</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Número de Documento</label>
                    <input type="text" name="numero_documento" class="form-control" required>
                    <div class="invalid-feedback">Ingrese el número de documento</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Primer Nombre</label>
                    <input type="text" name="primer_nombre" class="form-control" required>
                    <div class="invalid-feedback">Ingrese el primer nombre</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Segundo Nombre</label>
                    <input type="text" name="segundo_nombre" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Primer Apellido</label>
                    <input type="text" name="primer_apellido" class="form-control" required>
                    <div class="invalid-feedback">Ingrese el primer apellido</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Segundo Apellido</label>
                    <input type="text" name="segundo_apellido" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Sexo</label>
                    <select name="sexo_id" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <?php foreach ($datos['sexos'] ?? [] as $sexo): ?>
                            <option value="<?= $sexo['id'] ?>"><?= $sexo['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Seleccione el sexo</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Grupo Sanguíneo</label>
                    <select name="grupo_sanguineo_id" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <?php foreach ($datos['grupos_sanguineos'] ?? [] as $grupo): ?>
                            <option value="<?= $grupo['id'] ?>"><?= $grupo['tipo'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Seleccione el grupo sanguíneo</div>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Programa de Formación</label>
                    <select name="programa_formacion_id" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <?php foreach ($datos['programas'] ?? [] as $programa): ?>
                            <option value="<?= $programa['id'] ?>">
                                <?= $programa['nombre'] ?> - Ficha: <?= $programa['id'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Seleccione el programa de formación</div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once '../head/footer.php'; ?>