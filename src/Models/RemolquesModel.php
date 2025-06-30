<?php

namespace julio101290\boilerplateremolques\Models;

use CodeIgniter\Model;

class RemolquesModel extends Model {

    protected $table = 'remolques';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'idEmpresa', 'descripcion', 'subTipoRemolque', 'placa', 'updated_at', 'deleted_at', 'created_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $deletedField = 'deleted_at';
    protected $validationRules = [
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function mdlGetRemolquesServerSide($idEmpresas, $searchValue, $orderColumn, $orderDir, $start, $length) {
        $builder = $this->db->table('remolques a')
                ->select('a.id,a.idEmpresa,a.descripcion,a.subTipoRemolque,a.placa,a.updated_at,a.deleted_at,a.created_at,b.nombre AS nombreEmpresa')
                ->join('empresas b', 'a.idEmpresa = b.id')
                ->whereIn('a.idEmpresa', $idEmpresas);

        // Total sin filtros
        $total = $builder->countAllResults(false);

        // Búsqueda
        if ($searchValue) {
            $builder->groupStart()
                    ->like('a.descripcion', $searchValue)
                    ->orLike('a.subTipoRemolque', $searchValue)
                    ->orLike('a.placa', $searchValue)
                    ->orLike('b.nombre', $searchValue)
                    ->groupEnd();
        }

        // Total con búsqueda
        $filtered = $builder->countAllResults(false);

        // Orden
        if ($orderColumn && $orderDir) {
            $builder->orderBy($orderColumn, $orderDir);
        }

        // Paginación
        $builder->limit($length, $start);

        // Datos finales
        $data = $builder->get()->getResultArray();

        return [
            'total' => $total,
            'filtered' => $filtered,
            'data' => $data
        ];
    }
}
