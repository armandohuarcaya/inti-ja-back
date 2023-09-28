<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Data\Settings\IntipazData;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use App\FormatResponse\ApiResponse;
use Throwable;
use App\Helpers\Helpers;
class IntipazController
{
    use ApiResponse;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    
    }
    public function listEquipement(Request $request)
    {
        try {
            $data = IntipazData::listEquipement($request);
            if (count($data)>0) {
                return $this->ok($data);
            } else {
                return $this->information('', 'No hay información', 202);
            }
        } catch (Throwable $e) {
            return $this->error(Helpers::msgError($e), 400);
        }
    }
    public function listGroupEquipement(Request $request)
    {
        try {
            $data = IntipazData::listGroupEquipement($request);
            if (count($data)>0) {
                return $this->ok($data);
            } else {
                return $this->information('', 'No hay información', 202);
            }
        } catch (Throwable $e) {
            return $this->error(Helpers::msgError($e), 400);
        }
    }
    public function listTablePosition(Request $request)
    {
        try {
            $data = IntipazData::listTablePosition($request);
            if (count($data)>0) {
                return $this->ok($data);
            } else {
                return $this->information('', 'No hay información', 202);
            }
        } catch (Throwable $e) {
            return $this->error(Helpers::msgError($e), 400);
        }
    }
    public function listPartities(Request $request)
    {
        try {
            $data = IntipazData::listPartities($request);
            if (count($data)>0) {
                return $this->ok($data);
            } else {
                return $this->information('', 'No hay información', 202);
            }
        } catch (Throwable $e) {
            return $this->error(Helpers::msgError($e), 400);
        }
    }
    public function savePartities(Request $request)
    {
        $date = Carbon::now();
        $fecha_reg = $date->format('Y-m-d H:m:s');
        DB::beginTransaction();
        try {
            $result = IntipazData::savePartities($request, $fecha_reg);
            if($result['success']) {
                DB::commit();
                return $this->ok($result['data'], $result['message']);
            }else{
                DB::rollBack();
                return $this->information('', $result['message'], 202);
            }
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->error(Helpers::msgError($e), 400);
        }
    }
    public function updatePartities(Request $request, $id_partido)
    {
        $date = Carbon::now();
        $fecha_reg = $date->format('Y-m-d H:m:s');
        try {
            $result = IntipazData::updatePartities($request, $id_partido, $fecha_reg);
            if($result['success']) {
                return $this->ok($result['data'], $result['message']);
            }else{
                return $this->information('', $result['message'], 202);
            }
        } catch (Throwable $e) {
            return $this->error(Helpers::msgError($e), 400);
        }
    }
    public function deletePartities(Request $request, $id_partido)
    {
        DB::beginTransaction();
        try {
            $result = IntipazData::deletePartities($request, $id_partido);
            if($result['success']) {
                DB::commit();
                return $this->ok($result['data'], $result['message']);
            }else{
                DB::rollBack();
                return $this->information('', $result['message'], 202);
            }
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->error(Helpers::msgError($e), 400);
        }
    }
    public function getGroupEquipement(Request $request)
    {
        try {
            $data = IntipazData::getGroupEquipement($request);
            if (count($data)>0) {
                return $this->ok($data);
            } else {
                return $this->information('', 'No hay información', 202);
            }
        } catch (Throwable $e) {
            return $this->error(Helpers::msgError($e), 400);
        }
    }
    public function startPartities(Request $request, $id_partido)
    {
        DB::beginTransaction();
        try {
            $result = IntipazData::startPartities($request, $id_partido);
            if($result['success']) {
                DB::commit();
                return $this->ok($result['data'], $result['message']);
            }else{
                DB::rollBack();
                return $this->information('', $result['message'], 202);
            }
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->error(Helpers::msgError($e), 400);
        }
    }
    public function updateResultadoPartities(Request $request, $id_partido_detalle)
    {
        DB::beginTransaction();
        try {
            $result = IntipazData::updateResultadoPartities($request, $id_partido_detalle);
            if($result['success']) {
                DB::commit();
                return $this->ok($result['data'], $result['message']);
            }else{
                DB::rollBack();
                return $this->information('', $result['message'], 202);
            }
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->error(Helpers::msgError($e), 400);
        }
    }
    public function finishPartities(Request $request, $id_partido)
    {
        $date = Carbon::now();
        $fecha_reg = $date->format('Y-m-d H:m:s');
        DB::beginTransaction();
        try {
            $result = IntipazData::finishPartities($request, $id_partido, $fecha_reg);
            if($result['success']) {
                DB::commit();
                return $this->ok($result['data'], $result['message']);
            }else{
                DB::rollBack();
                return $this->information('', $result['message'], 202);
            }
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->error(Helpers::msgError($e), 400);
        }
    }
    public function saveGroup(Request $request)
    {
        $date = Carbon::now();
        $fecha_reg = $date->format('Y-m-d H:m:s');
        DB::beginTransaction();
        try {
            $result = IntipazData::saveGroup($request, $fecha_reg);
            if($result['success']) {
                DB::commit();
                return $this->ok($result['data'], $result['message']);
            }else{
                DB::rollBack();
                return $this->information('', $result['message'], 202);
            }
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->error(Helpers::msgError($e), 400);
        }
    }
    public function saveGroupsEquipe(Request $request)
    {
        $date = Carbon::now();
        $fecha_reg = $date->format('Y-m-d H:m:s');
        DB::beginTransaction();
        try {
            $result = IntipazData::saveGroupsEquipe($request, $fecha_reg);
            if($result['success']) {
                DB::commit();
                return $this->ok($result['data'], $result['message']);
            }else{
                DB::rollBack();
                return $this->information('', $result['message'], 202);
            }
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->error(Helpers::msgError($e), 400);
        }
    }
}