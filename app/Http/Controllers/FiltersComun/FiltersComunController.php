<?php

namespace App\Http\Controllers\FiltersComun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Data\FiltersComun\FiltersComunData;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use App\FormatResponse\ApiResponse;
use Throwable;
use App\Helpers\Helpers;
class FiltersComunController
{
    use ApiResponse;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    
    }
    public function getDicipline(Request $request)
    {
        try {
            $data = FiltersComunData::getDicipline($request);
            if (count($data)>0) {
                return $this->ok($data);
            } else {
                return $this->information('', 'No hay información', 202);
            }
        } catch (Throwable $e) {
            return $this->error(Helpers::msgError($e), 400);
        }
    }
    public function getCategory(Request $request)
    {
        try {
            $data = FiltersComunData::getCategory($request);
            if (count($data)>0) {
                return $this->ok($data);
            } else {
                return $this->information('', 'No hay información', 202);
            }
        } catch (Throwable $e) {
            return $this->error(Helpers::msgError($e), 400);
        }
    }
    public function getFase(Request $request)
    {
        try {
            $data = FiltersComunData::getFase($request);
            if (count($data)>0) {
                return $this->ok($data);
            } else {
                return $this->information('', 'No hay información', 202);
            }
        } catch (Throwable $e) {
            return $this->error(Helpers::msgError($e), 400);
        }
    }
    public function getGroup(Request $request)
    {
        try {
            $data = FiltersComunData::getGroup($request);
            if (count($data)>0) {
                return $this->ok($data);
            } else {
                return $this->information('', 'No hay información', 202);
            }
        } catch (Throwable $e) {
            return $this->error(Helpers::msgError($e), 400);
        }
    }
    public function getPeriodo(Request $request)
    {
        try {
            $data = FiltersComunData::getPeriodo($request);
            if (count($data)>0) {
                return $this->ok($data);
            } else {
                return $this->information('', 'No hay información', 202);
            }
        } catch (Throwable $e) {
            return $this->error(Helpers::msgError($e), 400);
        }
    }
    public function getEquipe(Request $request)
    {
        try {
            $data = FiltersComunData::getEquipe($request);
            if (count($data)>0) {
                return $this->ok($data);
            } else {
                return $this->information('', 'No hay información', 202);
            }
        } catch (Throwable $e) {
            return $this->error(Helpers::msgError($e), 400);
        }
    }
}