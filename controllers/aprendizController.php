<?php
require_once __DIR__ . '/../models/AprendizModel.php';

class AprendizController {
    private $model;
    
    public function __construct() {
        $this->model = new AprendizModel();
    }

    public function index() {
        try {
            $aprendices = $this->model->getAll();
            return [
                'status' => 'success',
                'data' => $aprendices
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al obtener los aprendices: ' . $e->getMessage()
            ];
        }
    }

    public function store($data) {
        try {
            // Verificar si ya existe el número de documento
            if ($this->model->existeNumeroDocumento($data['numero_documento'])) {
                return [
                    'status' => 'error',
                    'message' => 'El número de documento ya está registrado'
                ];
            }

            $resultado = $this->model->create($data);
            return [
                'status' => 'success',
                'message' => 'Aprendiz registrado exitosamente'
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al crear el aprendiz: ' . $e->getMessage()
            ];
        }
    }

    public function show($id) {
        try {
            $aprendiz = $this->model->getById($id);
            if (!$aprendiz) {
                return [
                    'status' => 'error',
                    'message' => 'Aprendiz no encontrado'
                ];
            }
            return [
                'status' => 'success',
                'data' => $aprendiz
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al obtener el aprendiz: ' . $e->getMessage()
            ];
        }
    }

    public function update($id, $data) {
        try {

            if (!$this->model->getById($id)) {
                return [
                    'status' => 'error',
                    'message' => 'Aprendiz no encontrado'
                ];
            }

            if ($this->model->existeNumeroDocumento($data['numero_documento'], $id)) {
                return [
                    'status' => 'error',
                    'message' => 'El número de documento ya está registrado'
                ];
            }

            $resultado = $this->model->update($id, $data);
            return [
                'status' => 'success',
                'message' => 'Aprendiz actualizado exitosamente'
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al actualizar el aprendiz: ' . $e->getMessage()
            ];
        }
    }

    public function destroy($id) {
        try {
            if (!$this->model->getById($id)) {
                return [
                    'status' => 'error',
                    'message' => 'Aprendiz no encontrado'
                ];
            }

            $resultado = $this->model->delete($id);
            return [
                'status' => 'success',
                'message' => 'Aprendiz eliminado exitosamente'
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al eliminar el aprendiz: ' . $e->getMessage()
            ];
        }
    }

    public function getDatosFormulario() {
        try {
            $datos = $this->model->getDatosFormulario();
            return [
                'status' => 'success',
                'data' => $datos
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al obtener datos del formulario: ' . $e->getMessage()
            ];
        }
    }
}