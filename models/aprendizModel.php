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
            s.nombre as nombre_sexo,
            s.codigo as codigo_sexo,
            gs.tipo as grupo_sanguineo,
            pf.nombre as programa_formacion,
            pf.id as numero_ficha
        FROM {$this->table} a
        JOIN tipos_documento td ON a.tipo_documento_id = td.id
        JOIN sexos s ON a.sexo_id = s.id
        JOIN grupos_sanguineos gs ON a.grupo_sanguineo_id = gs.id
        JOIN programas_formacion pf ON a.programa_formacion_id = pf.id
        ORDER BY a.created_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $query = "SELECT 
            a.*,
            td.nombre as tipo_documento,
            s.nombre as nombre_sexo,
            s.codigo as codigo_sexo,
            gs.tipo as grupo_sanguineo,
            pf.nombre as programa_formacion,
            pf.id as numero_ficha
        FROM {$this->table} a
        JOIN tipos_documento td ON a.tipo_documento_id = td.id
        JOIN sexos s ON a.sexo_id = s.id
        JOIN grupos_sanguineos gs ON a.grupo_sanguineo_id = gs.id
        JOIN programas_formacion pf ON a.programa_formacion_id = pf.id
        WHERE a.id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getDatosFormulario() {
        try {
            $stmtTipos = $this->db->query("SELECT id, nombre FROM tipos_documento ORDER BY nombre");
            $tipos_documento = $stmtTipos->fetchAll();

            $stmtSexos = $this->db->query("SELECT id, nombre FROM sexos ORDER BY nombre");
            $sexos = $stmtSexos->fetchAll();

            $stmtGrupos = $this->db->query("SELECT id, tipo FROM grupos_sanguineos ORDER BY tipo");
            $grupos_sanguineos = $stmtGrupos->fetchAll();

            $stmtProgramas = $this->db->query("SELECT id, nombre FROM programas_formacion WHERE estado = 'Activo' ORDER BY nombre");
            $programas = $stmtProgramas->fetchAll();

            return [
                'tipos_documento' => $tipos_documento,
                'sexos' => $sexos,
                'grupos_sanguineos' => $grupos_sanguineos,
                'programas' => $programas
            ];
        } catch (PDOException $e) {
            throw new Exception("Error al obtener datos del formulario: " . $e->getMessage());
        }
    }

    public function create($data) {
        $query = "INSERT INTO {$this->table} (
            tipo_documento_id, 
            numero_documento,
            primer_nombre,
            segundo_nombre,
            primer_apellido,
            segundo_apellido,
            sexo_id,
            grupo_sanguineo_id,
            programa_formacion_id
        ) VALUES (
            :tipo_documento_id,
            :numero_documento,
            :primer_nombre,
            :segundo_nombre,
            :primer_apellido,
            :segundo_apellido,
            :sexo_id,
            :grupo_sanguineo_id,
            :programa_formacion_id
        )";

        $stmt = $this->db->prepare($query);
        return $stmt->execute($this->sanitizarDatos($data));
    }

    public function update($id, $data) {
        $query = "UPDATE {$this->table} SET 
            tipo_documento_id = :tipo_documento_id,
            numero_documento = :numero_documento,
            primer_nombre = :primer_nombre,
            segundo_nombre = :segundo_nombre,
            primer_apellido = :primer_apellido,
            segundo_apellido = :segundo_apellido,
            sexo_id = :sexo_id,
            grupo_sanguineo_id = :grupo_sanguineo_id,
            programa_formacion_id = :programa_formacion_id
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

    private function sanitizarDatos($data) {
        $sanitized = [];
        foreach ($data as $key => $value) {
            $sanitized[$key] = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        }
        return $sanitized;
    }
}