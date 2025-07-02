<?php

namespace julio101290\boilerplateremolques\Controllers;

use App\Controllers\BaseController;
use julio101290\boilerplateremolques\Models\{
    RemolquesModel
};
use julio101290\boilerplatelog\Models\LogModel;
use CodeIgniter\API\ResponseTrait;
use julio101290\boilerplatecompanies\Models\EmpresasModel;

class RemolquesController extends BaseController {

    use ResponseTrait;

    protected $log;
    protected $remolques;

    public function __construct() {
        $this->remolques = new RemolquesModel();
        $this->log = new LogModel();
        $this->empresa = new EmpresasModel();
        helper('menu');
        helper('utilerias');
    }

    public function index() {



        helper('auth');

        $idUser = user()->id;
        $titulos["empresas"] = $this->empresa->mdlEmpresasPorUsuario($idUser);

        if (count($titulos["empresas"]) == "0") {

            $empresasID[0] = "0";
        } else {

            $empresasID = array_column($titulos["empresas"], "id");
        }




        if ($this->request->isAJAX()) {
            $request = service('request');
            $draw = $request->getGet('draw');
            $start = $request->getGet('start');
            $length = $request->getGet('length');
            $search = $request->getGet('search')['value'] ?? '';
            $order = $request->getGet('order');
            $columns = $request->getGet('columns');

            $orderColumnIndex = $order[0]['column'] ?? 0;
            $orderColumn = $columns[$orderColumnIndex]['data'] ?? 'a.id';
            $orderDir = $order[0]['dir'] ?? 'asc';

            $empresasID = [1, 2, 3]; // <- Aquí pones tus IDs reales o sacas de sesión

            $resultado = $this->remolques->mdlGetRemolquesServerSide(
                    $empresasID,
                    $search,
                    $orderColumn,
                    $orderDir,
                    $start,
                    $length
            );

            return $this->response->setJSON([
                        'draw' => intval($draw),
                        'recordsTotal' => $resultado['total'],
                        'recordsFiltered' => $resultado['filtered'],
                        'data' => $resultado['data']
            ]);
        }
        $titulos["title"] = lang('remolques.title');
        $titulos["subtitle"] = lang('remolques.subtitle');
        return view('julio101290\boilerplateremolques\Views\remolques', $titulos);
    }

    /**
     * Read Remolques
     */
    public function getRemolques() {

        helper('auth');

        $idUser = user()->id;
        $titulos["empresas"] = $this->empresa->mdlEmpresasPorUsuario($idUser);

        if (count($titulos["empresas"]) == "0") {

            $empresasID[0] = "0";
        } else {

            $empresasID = array_column($titulos["empresas"], "id");
        }


        $idRemolques = $this->request->getPost("idRemolques");
        $datosRemolques = $this->remolques->whereIn('idEmpresa', $empresasID)
                        ->where("id", $idRemolques)->first();
        echo json_encode($datosRemolques);
    }

    /**
     * Save or update Remolques
     */
    public function save() {
        helper('auth');
        $userName = user()->username;
        $idUser = user()->id;
        $datos = $this->request->getPost();
        if ($datos["idRemolques"] == 0) {
            try {
                if ($this->remolques->save($datos) === false) {
                    $errores = $this->remolques->errors();
                    foreach ($errores as $field => $error) {
                        echo $error . " ";
                    }
                    return;
                }
                $dateLog["description"] = lang("vehicles.logDescription") . json_encode($datos);
                $dateLog["user"] = $userName;
                $this->log->save($dateLog);
                echo "Ok " . lang("remolques.msg.msg_save_success");
            } catch (\PHPUnit\Framework\Exception $ex) {
                echo lang("remolques.msg.msg_save_success") . $ex->getMessage();
            }
        } else {
            if ($this->remolques->update($datos["idRemolques"], $datos) == false) {
                $errores = $this->remolques->errors();
                foreach ($errores as $field => $error) {
                    echo $error . " ";
                }
                return;
            } else {
                $dateLog["description"] = lang("remolques.logUpdated") . json_encode($datos);
                $dateLog["user"] = $userName;
                $this->log->save($dateLog);
                echo "Ok " . lang("remolques.msg.msg_update_success");
                return;
            }
        }
        return;
    }

    /**
     * Delete Remolques
     * @param type $id
     * @return type
     */
    public function delete($id) {
        $infoRemolques = $this->remolques->find($id);
        helper('auth');
        $userName = user()->username;
        if (!$found = $this->remolques->delete($id)) {
            return $this->failNotFound(lang('remolques.msg.msg_get_fail'));
        }
        $this->remolques->purgeDeleted();
        $logData["description"] = lang("remolques.logDeleted") . json_encode($infoRemolques);
        $logData["user"] = $userName;
        $this->log->save($logData);
        return $this->respondDeleted($found, lang('remolques.msg_delete'));
    }

    /**
     * Get Storages via AJax
     */
    public function getRemolquesAjax() {

        $request = service('request');
        $postData = $request->getPost();

        $response = array();

        // Read new token and assign in $response['token']
        $response['token'] = csrf_hash();

        helper('auth');
        $userName = user()->username;
        $idUser = user()->id;

        $idEmpresa = $postData['idEmpresa'];

        if (!isset($postData['searchTerm'])) {

            $searchTerm = "";
        } else {

            $searchTerm = $postData['searchTerm'];
        }

        $db = \Config\Database::connect();
        $searchTerm = strtolower($db->escapeLikeString($searchTerm));

        $listRemolques = $this->remolques
                ->select('id, descripcion')
                ->where('"idEmpresa"', $idEmpresa) // usar comillas si la columna es "idEmpresa"
                ->where('LOWER(descripcion) LIKE', "%{$searchTerm}%") // LIKE case-insensitive
                ->findAll();
        
        $data = array();

        $data[] = array(
            "id" => "0",
            "text" => "0 " . lang("remolques.withOutRemolque"),
        );

        foreach ($listRemolques as $remolques) {
            $data[] = array(
                "id" => $remolques['id'],
                "text" => $remolques['id'] . ' ' . $remolques['descripcion'],
            );
        }

        $response['data'] = $data;

        return $this->response->setJSON($response);
    }
}
