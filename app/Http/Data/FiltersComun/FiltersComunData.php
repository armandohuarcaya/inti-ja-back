<?php
namespace App\Http\Data\FiltersComun;

use Illuminate\Support\Facades\DB;
use PDO;
use App\Helpers\Helpers;

class FiltersComunData
{
    public static function getDicipline($request)
    {
        $q = DB::table('inti_diciplinas as a');
        $q->select('*');
        $q->orderBy('a.id_diciplina', 'asc');
        $data = $q->get();
        return $data;
    }
    public static function getCategory($request)
    {
        $q = DB::table('inti_categorias as a');
        $q->select('*');
        $q->orderBy('a.id_categoria', 'asc');
        $data = $q->get();
        return $data;
    }
    public static function getFase($request)
    {
        $q = DB::table('inti_fases as a');
        $q->select('*');
        $q->orderBy('a.id_fase', 'asc');
        $data = $q->get();
        return $data;
    }
    public static function getGroup($request)
    {
        $id_periodo = $request->id_periodo;

        $q = DB::table('inti_grupos as a');
        $q->select('*');
        $q->where('a.id_periodo', '=', $id_periodo);
        $q->orderBy('a.id_grupo', 'asc');
        $data = $q->get();
        return $data;
    }
    public static function getPeriodo($request)
    {
        $estado = $request->estado;
        $id_tipo_evento = $request->id_tipo_evento;
        $q = DB::table('inti_periodos as a');
        $q->select('*');
        if (isset($estado)) {
            $q->where('a.estado', '=', $estado);
        }
        if (isset($id_tipo_evento)) {
            $q->where('a.id_tipo_evento', '=', $id_tipo_evento);
        }
        $q->orderBy('a.id_periodo', 'asc');
        $data = $q->get();
        return $data;
    }
    public static function getEquipe($request)
    {
        $id_periodo = $request->id_periodo;
        $id_iglesia = $request->id_iglesia;
        $q = DB::table('inti_equipos as a');
        $q->select('*');
        $q->where('a.id_periodo', '=', $id_periodo);
        $q->where('a.id_iglesia', '=', $id_iglesia);
        $q->orderBy('a.id_equipo', 'asc');
        $data = $q->get();
        return $data;
    }
}