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

    public function mdlGetRemolques($idEmpresas) {

        $result = $this->db->table('remolques a, empresas b')
                ->select('a.id,a.idEmpresa,a.descripcion,a.subTipoRemolque,a.placa,a.updated_at,a.deleted_at,a.created_at ,b.nombre as nombreEmpresa')
                ->where('a.idEmpresa', 'b.id', FALSE)
                ->whereIn('a.idEmpresa', $idEmpresas);

        return $result;
    }

}
