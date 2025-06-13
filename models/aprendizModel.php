<?php
<?php
require_once __DIR__ . '/../database/conexion.php';

class AprendizModel {
    private $db;
    private $table = 'aprendices';

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAll() {
        $query = "SELECT 
            a.*,
            td.nombre as tipo_documento,
            gs.tipo as grupo_sanguineo,
            f.numero as numero_ficha,
            pf.nombre as programa_formacion
        FROM {$this->table} a
        JOIN tipos_documento td ON a.tipo_documento_id = td.id
        JOIN grupos_sanguineos gs ON a.grupo_sanguineo_id = gs.id
        JOIN fichas f ON a.ficha_id = f.id
        JOIN programas_formacion pf ON f.programa_id = pf.id
        ORDER BY a.created_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create($data) {
        $this->validarDatos($data);

        $query = "INSERT INTO {$this->table} (
            tipo_documento_id,
            numero_documento,
            primer_nombre,
            segundo_nombre,
            primer_apellido,
            segundo_apellido,
            sexo,
            grupo_sanguineo_id,
            ficha_id
        ) VALUES (
            :tipo_documento_id,
            :numero_documento,
            :primer_nombre,
            :segundo_nombre,
            :primer_apellido,
            :segundo_apellido,
            :sexo,
            :grupo_sanguineo_id,
            :ficha_id
        )";

        $stmt = $this->db->prepare($query);
        return $stmt->execute($this->sanitizarDatos($data));
    }

    public function update($id, $data) {
        $this->validarDatos($data);

        $query = "UPDATE {$this->table} SET 
            tipo_documento_id = :tipo_documento_id,
            numero_documento = :numero_documento,
            primer_nombre = :primer_nombre,
            segundo_nombre = :segundo_nombre,
            primer_apellido = :primer_apellido,
            segundo_apellido = :segundo_apellido,
            sexo = :sexo,
            grupo_sanguineo_id = :grupo_sanguineo_id,
            ficha_id = :ficha_id
        WHERE id = :id";

        $data['id'] = $id;
        $stmt = $this->db->prepare($query);
        return $stmt->execute($this->sanitizarDatos($data));
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    private function validarDatos($data) {
        $errores = [];

        // Validar campos requeridos
        $camposRequeridos = [
            'tipo_documento_id' => 'El tipo de documento es requerido',
            'numero_documento' => 'El número de documento es requerido',
            'primer_nombre' => 'El primer nombre es requerido',
            'primer_apellido' => 'El primer apellido es requerido',
            'sexo' => 'El sexo es requerido',
            'grupo_sanguineo_id' => 'El grupo sanguíneo es requerido',
            'ficha_id' => 'La ficha es requerida'
        ];

        foreach ($camposRequeridos as $campo => $mensaje) {
            if (!isset($data[$campo]) || empty(trim($data[$campo]))) {
                $errores[] = $mensaje;
            }
        }

        // Validar formato del número de documento
        if (isset($data['numero_documento']) && !preg_match('/^[0-9]+$/', $data['numero_documento'])) {
            $errores[] = "El número de documento debe contener solo números";
        }

        // Validar sexo
        if (isset($data['sexo']) && !in_array($data['sexo'], ['M', 'F', 'O'])) {
            $errores[] = "El sexo debe ser M, F u O";
        }

        if (!empty($errores)) {
            throw new Exception(implode(". ", $errores));
        }

        return true;
    }

    private function sanitizarDatos($data) {
        $sanitized = [];
        foreach ($data as $key => $value) {
            $sanitized[$key] = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        }
        return $sanitized;
    }

    public function existeNumeroDocumento($numero, $id = null) {
        $query = "SELECT COUNT(*) FROM {$this->table} WHERE numero_documento = :numero";
        $params = [':numero' => $numero];
        
        if ($id !== null) {
            $query .= " AND id != :id";
            $params[':id'] = $id;
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn() > 0;
    }
}