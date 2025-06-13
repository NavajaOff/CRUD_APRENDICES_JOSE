<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NVJ || Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="container-fluid">
            <div class="row">
                    <?php
                    session_start();
                    require_once '../../controllers/AprendizController.php';
                    require_once '../head/head.php';

                    // Manejar mensajes por GET
                    if (isset($_GET['status']) && isset($_GET['message'])) {
                        echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    icon: '" . htmlspecialchars($_GET['status']) . "',
                                    title: '" . ($_GET['status'] === 'success' ? '¡Éxito!' : 'Error') . "',
                                    text: '" . htmlspecialchars($_GET['message']) . "',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            });
                        </script>";
                    }

                    $controller = new AprendizController();
                    $resultado = $controller->index();

                    if ($resultado['status'] === 'success') {
                        $aprendices = $resultado['data'];
                    } else {
                        $aprendices = [];
                        echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: '{$resultado['message']}'
                                });
                            });
                        </script>";
                    }
                    ?>

                    <div class="card shadow">
                        <div class="card-header bg-success text-white">
                            <h4 class="mb-0"><i class="fas fa-users"></i> Gestión de Aprendices</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <a href="crear.php" class="btn btn-success">
                                    <i class="fas fa-plus-circle"></i> Nuevo Aprendiz
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Documento</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Sexo</th>
                                            <th>Ficha</th>
                                            <th>Programa</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($aprendices as $aprendiz): ?>
                                        <tr>
                                            <td><?= $aprendiz['id'] ?></td>
                                            <td>
                                                <?= $aprendiz['tipo_documento'] ?><br>
                                                <?= $aprendiz['numero_documento'] ?>
                                            </td>
                                            <td>
                                                <?= $aprendiz['primer_nombre'] ?> 
                                                <?= $aprendiz['segundo_nombre'] ?>
                                            </td>
                                            <td>
                                                <?= $aprendiz['primer_apellido'] ?> 
                                                <?= $aprendiz['segundo_apellido'] ?>
                                            </td>
                                            <td><?= $aprendiz['nombre_sexo'] ?></td>
                                            <td><?= $aprendiz['numero_ficha'] ?></td>
                                            <td><?= $aprendiz['programa_formacion'] ?></td>
                                            <td>
                                                <span class="badge bg-<?= $aprendiz['estado'] === 'Activo' ? 'success' : 'danger' ?>">
                                                    <?= $aprendiz['estado'] ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="ver.php?id=<?= $aprendiz['id'] ?>" class="btn btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="editar.php?id=<?= $aprendiz['id'] ?>" class="btn btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                        class="btn btn-danger" 
                                                        onclick="Swal.fire({
                                                            title: '¿Estás seguro?',
                                                            text: 'Esta acción no se puede deshacer',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#d33',
                                                            cancelButtonColor: '#3085d6',
                                                            confirmButtonText: 'Sí, eliminar',
                                                            cancelButtonText: 'Cancelar'
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                window.location.href = 'delete.php?id=<?= $aprendiz['id'] ?>';
                                                            }
                                                        })">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>