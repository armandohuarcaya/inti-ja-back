<?php
namespace App\Http\Data\Settings;

use Illuminate\Support\Facades\DB;
use PDO;
use App\Helpers\Helpers;

class IntipazData
{
    public static function listEquipement($request)
    {
        $id_periodo = $request->id_periodo;
        $q = DB::table('inti_equipos as a');
        $q->join('inti_iglesias as b', 'a.id_iglesia', '=', 'b.id_iglesia');
        $q->select('a.*', 'b.nombre as iglesia');
        $q->where('a.id_periodo', '=', $id_periodo);
        $q->orderBy('a.id_equipo', 'asc');
        $data = $q->get();
        return $data;
    }
    public static function listGroupEquipement($request)
    {
        $id_periodo = $request->id_periodo;
        $id_diciplina = $request->id_diciplina;
        $id_categoria = $request->id_categoria;

        $q = DB::table('inti_grupo_equipo as a');
        $q->join('inti_equipos as b', 'a.id_equipo', '=', 'b.id_equipo');
        $q->join('inti_grupos as c', 'a.id_grupo', '=', 'c.id_grupo');
        $q->join('inti_categorias as d', 'a.id_categoria', '=', 'd.id_categoria');
        $q->join('inti_diciplinas as e', 'a.id_diciplina', '=', 'e.id_diciplina');
        $q->select('a.id_grupo_equipo', 'a.id_equipo', 'a.id_grupo', 'a.id_categoria', 'a.id_diciplina', 'b.nombre as equipo', 'b.logo', 'c.nombre as grupo',
        'd.nombre as categoria', 'd.codigo as codigo_categoria', 'e.codigo as codigo_diciplina', 'e.nombre as diciplina',
        DB::raw("CONCAT(c.nombre,' - ',d.nombre,' - ',a.id_grupo,' - ',a.id_categoria) as grupo_categoria"));
        $q->where('a.id_periodo', '=', $id_periodo);
        $q->where('a.id_diciplina', '=', $id_diciplina);
        if (!empty($id_categoria)) {
            $q->where('a.id_categoria', '=', $id_categoria);
        }
        $q->orderBy('a.id_grupo_equipo', 'asc');
        $data = $q->get();

        $datar = array();

        $da = collect($data)->groupBy('grupo_categoria'); 
        $datar = array();
        foreach ($da as $key => $value) {
            $separa = explode(" - ", $key);
            array_push($datar, ['grupo_categoria' => $separa[0].' - '.$separa[1], 'categoria' => $separa[1], 'id_grupo' => $separa[2], 'id_categoria' => $separa[3], 'data' => $value]);
        }
        return $datar;
    }
    public static function listTablePosition($request)
    {
        $id_periodo = $request->id_periodo;
        $id_diciplina = $request->id_diciplina;
        $id_categoria = $request->id_categoria;

        $q = DB::table('inti_grupo_equipo as a');
        $q->join('inti_equipos as b', 'a.id_equipo', '=', 'b.id_equipo');
        $q->join('inti_grupos as c', 'a.id_grupo', '=', 'c.id_grupo');
        $q->join('inti_categorias as d', 'a.id_categoria', '=', 'd.id_categoria');
        $q->join('inti_diciplinas as e', 'a.id_diciplina', '=', 'e.id_diciplina');
        $q->select('a.id_grupo_equipo', 'a.id_equipo', 'a.id_grupo', 'a.id_categoria', 'a.id_diciplina', 'b.nombre as equipo', 'b.logo', 'c.nombre as grupo',
        'a.partido_jugado', 'a.ganado', 'a.empate', 'a.perdido', 'a.goles_favor', 'a.goles_contra', 'a.diferencia_goles', 'a.puntos',
        'd.nombre as categoria', 'd.codigo as codigo_categoria', 'e.codigo as codigo_diciplina', 'e.nombre as diciplina',
        DB::raw("CONCAT(c.nombre,' - ',d.nombre) as grupo_categoria"));
        $q->where('a.id_periodo', '=', $id_periodo);
        $q->where('a.id_diciplina', '=', $id_diciplina);
        if (!empty($id_categoria)) {
            $q->where('a.id_categoria', '=', $id_categoria);
        }
        $q->orderBy('a.puntos', 'desc');
        $q->orderBy('a.diferencia_goles', 'desc');
        $data = $q->get();

        $datar = array();

        $da = collect($data)->groupBy('grupo_categoria'); 
        $datar = array();
        foreach ($da as $key => $value) {
            $separa = explode(" - ", $key);
            foreach ($value as $det) {
                $item = (object)$det;
                $item->partidos = self::listMonitor($item->id_grupo_equipo);
            }
            array_push($datar, ['grupo_categoria' => $key, 'categoria' => $separa[1], 'data' => $value]);
        }
        return $datar;
    }
    public static function listMonitor($id_grupo_equipo)
    {
        $q = DB::table('inti_partidos_detalle_monitor as a');
        $q->select('a.id_partido_detalle_monitor', 'a.id_partido_detalle', 'a.partido', 'a.id_grupo_equipo');
        $q->where('a.id_grupo_equipo', '=', $id_grupo_equipo);
        $q->orderBy('a.id_partido_detalle_monitor', 'asc');
        $data = $q->get();
        return $data;
    }
    public static function listPartities($request)
    {
        $id_periodo = $request->id_periodo;
        $id_diciplina = $request->id_diciplina;
        $id_categoria = $request->id_categoria;
        $id_fase = $request->id_fase;

        $q = DB::table('inti_partidos as a');
        $q->leftJoin('inti_grupos as c', 'a.id_grupo', '=', 'c.id_grupo');
        $q->leftJoin('inti_categorias as d', 'a.id_categoria', '=', 'd.id_categoria');
        $q->leftJoin('inti_diciplinas as e', 'a.id_diciplina', '=', 'e.id_diciplina');
        $q->leftJoin('inti_fases as f', 'a.id_fase', '=', 'f.id_fase');
        $q->select('a.id_partido', 'a.fecha', 'a.hora_inicio', 'a.hora_fin', 'a.resultado', 'a.id_periodo', 'a.finalizado', 'a.id_fase', 'a.id_grupo', 
        'a.id_categoria', 'a.id_diciplina', 'a.orden', 'c.nombre as grupo', 'd.nombre as categoria','e.nombre as diciplina', 'f.nombre as fase');
        $q->where('a.id_periodo', '=', $id_periodo);
        if (!empty($id_diciplina)) {
            $q->where('a.id_diciplina', '=', $id_diciplina);
        }
        if (!empty($id_categoria)) {
            $q->where('a.id_categoria', '=', $id_categoria);
        }
        $q->where('a.id_fase', '=', $id_fase);
        $q->orderBy('a.orden', 'asc');
        $data = $q->get();
        // dd($data);

        foreach ($data as $value) {
            $item = (object)$value;
            $item->details = self::listPartitiesDetails($item->id_partido);
        }
        return $data;
    }
    public static function listPartitiesDetails($id_partido)
    {
        $q = DB::table('inti_partidos_detalle as a');
        $q->join('inti_grupo_equipo as b', 'a.id_grupo_equipo', '=', 'b.id_grupo_equipo');
        $q->join('inti_equipos as c', 'b.id_equipo', '=', 'c.id_equipo');
        $q->select('a.id_partido_detalle', 'a.id_grupo_equipo', 'a.gano', 'a.id_partido', 'a.resultado as puntos', 'c.nombre as equipo', 'c.logo');
        $q->where('a.id_partido', '=', $id_partido);
        $q->orderBy('a.id_partido_detalle', 'asc');
        $data = $q->get();
     
        return $data;
    }
    
    public static function savePartities($request, $fecha_reg)
    {
        $fecha = $request->fecha;
        $hora_inicio = $request->hora_inicio;
        $hora_fin = $request->hora_fin;
        $id_periodo = $request->id_periodo;
        $id_fase = $request->id_fase;
        $id_grupo = $request->id_grupo;
        $id_categoria = $request->id_categoria;
        $id_diciplina = $request->id_diciplina;
        $orden = $request->orden;

        $array_id_grupo_equipo = $request->array_id_grupo_equipo;

        $id_partido =  Helpers::correlativo('inti_partidos', 'id_partido');

        if ($id_partido) {
            $save = DB::table('inti_partidos')->insert([
                'id_partido' => $id_partido,
                'fecha' => $fecha,
                'hora_inicio' => $hora_inicio,
                'hora_fin' => $hora_fin,
                'id_periodo' => $id_periodo,
                'finalizado' => 'N',
                'created_at' => $fecha_reg,
                'id_fase' => $id_fase,
                'id_grupo' => $id_grupo,
                'id_categoria' => $id_categoria,
                'id_diciplina' => $id_diciplina,
                'orden' => $orden,
            ]);
            if ($save) {
                $data = array();
                $id_partido_detalle =  Helpers::correlativo('inti_partidos_detalle', 'id_partido_detalle');
                foreach ($array_id_grupo_equipo as $value) {
                    $it = (Object)$value;
                    $item = [
                        'id_partido_detalle' => $id_partido_detalle,
                        'id_grupo_equipo' => $it->id_grupo_equipo,
                        'gano' => 'N',
                        'id_partido' => $id_partido,
                        'resultado' => 0,
                        'created_at' => $fecha_reg,
                    ];
                    array_push($data, $item);
                    $id_partido_detalle = $id_partido_detalle + 1;
                }

             
                $saveDetails = DB::table('inti_partidos_detalle')->insert($data);

                if ($saveDetails) {
                    $response = [
                        'success' => true,
                        'message' => 'Ingresado satisfactoriamente',
                        'data' => $id_partido
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'No se pudo registrar por completo',
                        'data' => $id_partido
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No se pudo registrar el partido',
                    'data' => $id_partido
                ];
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'No se encontro correlativo',
                'data' => ''
            ];
        }
        
        return $response;
    }
    public static function updatePartities($request, $id_partido, $fecha_reg)
    {
        $orden = $request->orden;

        $update = DB::table('inti_partidos')->where('id_partido', '=', $id_partido)->update([
            'orden' => $orden,
        ]);
        if ($update) {
            $response = [
                'success' => true,
                'message' => 'Actualizado satisfactoriamente',
                'data' => $id_partido
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No se pudo actualizar',
                'data' => $id_partido
            ];
        }
        return $response;
    }
    public static function deletePartities($request, $id_partido)
    {
        $deleteDetails = DB::table('inti_partidos_detalle')->where('id_partido', '=', $id_partido)->delete();
 
        if ($deleteDetails) {
            $delete = DB::table('inti_partidos')->where('id_partido', '=', $id_partido)->delete();
            if ($delete) {
                $response = [
                    'success' => true,
                    'message' => 'Eliminado satisfactoriamente',
                    'data' => $delete
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No se pudo eliminar',
                    'data' => $delete
                ]; 
            }
            
        } else {
            $response = [
                'success' => false,
                'message' => 'No se pudo eliminar el detalle',
                'data' => $deleteDetails
            ];
        }
        return $response;
    }
    public static function getGroupEquipement($request)
    {
        $id_periodo = $request->id_periodo;
        $id_diciplina = $request->id_diciplina;
        $id_categoria = $request->id_categoria;
        $id_grupo = $request->id_grupo;

        $q = DB::table('inti_grupo_equipo as a');
        $q->join('inti_equipos as b', 'a.id_equipo', '=', 'b.id_equipo');
        $q->join('inti_grupos as c', 'a.id_grupo', '=', 'c.id_grupo');
        $q->join('inti_categorias as d', 'a.id_categoria', '=', 'd.id_categoria');
        $q->join('inti_diciplinas as e', 'a.id_diciplina', '=', 'e.id_diciplina');
        $q->select('a.id_grupo_equipo', 'a.id_equipo', 'a.id_grupo', 'a.id_categoria', 'a.id_diciplina', 'b.nombre as equipo', 'b.logo', 'c.nombre as grupo',
        'd.nombre as categoria', 'd.codigo as codigo_categoria', 'e.codigo as codigo_diciplina', 'e.nombre as diciplina');
        $q->where('a.id_periodo', '=', $id_periodo);
        $q->where('a.id_diciplina', '=', $id_diciplina);
        $q->where('a.id_categoria', '=', $id_categoria);
        if (!empty($id_grupo)) {
            $q->where('a.id_grupo', '=', $id_grupo);
        }
        $q->orderBy('a.id_grupo_equipo', 'asc');
        $data = $q->get();
        return $data;
    }
    public static function startPartities($request, $id_partido)
    {
        $finalizado = $request->finalizado;

        $update = DB::table('inti_partidos')->where('id_partido', '=', $id_partido)->update([
            'finalizado' => $finalizado,
        ]);
        if ($update) {
            $response = [
                'success' => true,
                'message' => 'Actualizado satisfactoriamente',
                'data' => $id_partido
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No se pudo actualizar',
                'data' => $id_partido
            ];
        }
        return $response;
    }
    public static function updateResultadoPartities($request, $id_partido_detalle)
    {
        $resultado = $request->resultado;

        $update = DB::table('inti_partidos_detalle')->where('id_partido_detalle', '=', $id_partido_detalle)->update([
            'resultado' => $resultado,
        ]);
        if ($update) {
            $response = [
                'success' => true,
                'message' => 'Actualizado satisfactoriamente',
                'data' => $id_partido_detalle
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No se pudo actualizar',
                'data' => $id_partido_detalle
            ];
        }
        return $response;
    }
    public static function finishPartities($request, $id_partido, $fecha_reg)
    {
        $finalizado = $request->finalizado;
        $id_fase = $request->id_fase;

        $fase = DB::table('inti_fases')->where('id_fase', '=', $id_fase)->select('codigo')->first();

        
        if ($fase->codigo == 'FDGPS') { //Fase de grupos
            $update = DB::table('inti_partidos')->where('id_partido', '=', $id_partido)->update([
                'finalizado' => $finalizado,
                'updated_at' => $fecha_reg
            ]);
            if ($update) {
    
                $response = [
                    'success' => true,
                    'message' => 'Actualizado, para la fase de grupos',
                    'data' => $update
                ];
    
                $detalle = DB::table('inti_partidos_detalle')
                ->select('id_partido_detalle', 'resultado', 'id_grupo_equipo')
                ->where('id_partido', '=', $id_partido)
                ->get();
    
                if ($detalle[0]->resultado > $detalle[1]->resultado) {
                    $mejorJugador = $detalle[0];
                } elseif ($detalle[1]->resultado > $detalle[0]->resultado) {
                    $mejorJugador = $detalle[1];
                } else {
                    $mejorJugador = null; // Empate
                }
    
                if (!empty($mejorJugador)) {
                    $updateDetalle = DB::table('inti_partidos_detalle')->where('id_partido_detalle', '=', $mejorJugador->id_partido_detalle)->update([
                        'gano' => 'S',
                        'updated_at' => $fecha_reg
                    ]);
                }
    
                foreach ($detalle as $value) {
                    $item = (Object)$value;
    
                    $datos = DB::table('inti_grupo_equipo')->where('id_grupo_equipo', '=', $item->id_grupo_equipo)
                    ->select('partido_jugado', 'ganado', 'empate', 'perdido', 'goles_favor', 'goles_contra', 'diferencia_goles', 'puntos')->first();
    
                    // if (empty($mejorJugador)) {
                    //     $puntos = ((int)$datos->puntos + 1);
                    // } elseif (!empty($mejorJugador) and ($item->id_grupo_equipo == $mejorJugador->id_grupo_equipo)) {
                    //     $puntos = ((int)$datos->puntos + 3);
                    // } else {
                    //     $puntos = ((int)$datos->puntos);
                    // }
                    
                    $tabla = DB::table('inti_grupo_equipo')->where('id_grupo_equipo', '=', $item->id_grupo_equipo)->update([
                        'partido_jugado' => (int)$datos->partido_jugado + 1,
                        'ganado' => (!empty($mejorJugador) and ($item->id_grupo_equipo == $mejorJugador->id_grupo_equipo)) ? ((int)$datos->ganado + 1) : (int)$datos->ganado,
                        'empate' => empty($mejorJugador) ? ((int)$datos->empate + 1) : (int)$datos->empate,
                        'perdido' => (!empty($mejorJugador) and ($item->id_grupo_equipo != $mejorJugador->id_grupo_equipo)) ? ((int)$datos->perdido + 1) : (int)$datos->perdido,
                        'goles_favor' => ((int)$datos->goles_favor + (int)$item->resultado),
                        'goles_contra' => ((int)$datos->goles_contra + ((!empty($mejorJugador) and ($item->id_grupo_equipo != $mejorJugador->id_grupo_equipo)) ? ((int)$mejorJugador->resultado || 0) : 0)),
                        'diferencia_goles' => ((int)$datos->goles_favor - ((!empty($mejorJugador) and ($item->id_grupo_equipo != $mejorJugador->id_grupo_equipo)) ? ((int)$mejorJugador->resultado || 0) : 0)),
                        // 'puntos' => $puntos,
                        'updated_at' => $fecha_reg
                    ]);
    
                    $datoDos = DB::table('inti_grupo_equipo')->where('id_grupo_equipo', '=', $item->id_grupo_equipo)
                    ->select('partido_jugado', 'ganado', 'empate', 'perdido', 'goles_favor', 'goles_contra', 'diferencia_goles', 'puntos')->first();
    
                    $puntos = ((int)$datoDos->ganado * 3) + ((int)$datoDos->empate * 1) + ((int)$datoDos->perdido * 0);
    
                    $tablaDos = DB::table('inti_grupo_equipo')->where('id_grupo_equipo', '=', $item->id_grupo_equipo)->update([
                        'diferencia_goles' => ((int)$datoDos->goles_favor - (int)$datoDos->goles_contra),
                        'puntos' => $puntos,
                        'updated_at' => $fecha_reg
                    ]);
    
                    if (!empty($mejorJugador) and ($mejorJugador->id_partido_detalle == $item->id_partido_detalle)) {
                        $partido = 'G';
                    }
                    if (!empty($mejorJugador) and ($mejorJugador->id_partido_detalle != $item->id_partido_detalle)) {
                        $partido = 'P';
                    }
                    if (empty($mejorJugador)) {
                        $partido = 'E';
                    }
                    $id_partido_detalle_monitor =  Helpers::correlativo('inti_partidos_detalle_monitor', 'id_partido_detalle_monitor');
                    $monitor = DB::table('inti_partidos_detalle_monitor')->insert([
                        'id_partido_detalle_monitor' => $id_partido_detalle_monitor,
                        'id_partido_detalle' => $item->id_partido_detalle,
                        'id_grupo_equipo' => $item->id_grupo_equipo,
                        'partido' => $partido,
                        'created_at' => $fecha_reg
                    ]);
                }
    
    
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No se pudo actualizar',
                    'data' => $update
                ];
            }
        } else {
            $update = DB::table('inti_partidos')->where('id_partido', '=', $id_partido)->update([
                'finalizado' => $finalizado,
                'updated_at' => $fecha_reg
            ]);

            if($update) {
                $response = [
                    'success' => true,
                    'message' => 'Actualizado, para otras fases',
                    'data' => $update
                ];
    
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No se pudo actualizar',
                    'data' => $update
                ];
            }
        }
        
        return $response;
    }
    public static function saveGroup($request, $fecha_reg)
    {
        $id_periodo = $request->id_periodo;
        $nombre = $request->nombre;
        $estado = $request->estado;

        $id_grupo =  Helpers::correlativo('inti_grupos', 'id_grupo');

        if ($id_grupo) {
            $save = DB::table('inti_grupos')->insert([
                'id_grupo' => $id_grupo,
                'id_periodo' => $id_periodo,
                'nombre' => $nombre,
                'estado' => $estado,
                'created_at' => $fecha_reg,
            ]);
            if ($save) {
                $response = [
                    'success' => true,
                    'message' => 'Ingresado satisfactoriamente',
                    'data' => $save
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No se pudo registrar por completo',
                    'data' => $save
                ];
            }

        } else {
            $response = [
                'success' => false,
                'message' => 'No se encontro correlativo',
                'data' => ''
            ];
        }
        
        return $response;
    }
    public static function saveGroupsEquipe($request, $fecha_reg)
    {
        $id_periodo = $request->id_periodo;
        $id_grupo = $request->id_grupo;
        $id_categoria = $request->id_categoria;
        $id_diciplina = $request->id_diciplina;

        $array_equipo = $request->array_equipo;

        $data = array();
        $id_grupo_equipo =  Helpers::correlativo('inti_grupo_equipo', 'id_grupo_equipo');
        foreach ($array_equipo as $value) {
            $item = (object)$value;
            $item = [
                'id_grupo_equipo' => $id_grupo_equipo,
                'id_grupo' => $id_grupo,
                'id_equipo' => $item->id_equipo,
                'id_categoria' => $id_categoria,
                'id_diciplina' => $id_diciplina,
                'id_periodo' => $id_periodo,
                'partido_jugado' => 0,
                'ganado' => 0,
                'empate' => 0,
                'perdido' => 0,
                'goles_favor' => 0,
                'goles_contra' => 0,
                'diferencia_goles' => 0,
                'puntos' => 0,
                'created_at' => $fecha_reg,
            ];
            array_push($data, $item);
            $id_grupo_equipo = $id_grupo_equipo + 1;
        }

        
        $savegp = DB::table('inti_grupo_equipo')->insert($data);
        if ($savegp) {
            $response = [
                'success' => true,
                'message' => 'Ingresado satisfactoriamente',
                'data' => $savegp
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No se pudo registrar por completo',
                'data' => $savegp
            ];
        }
        
        return $response;
    }
    // public static function deleteEquipeGrups($request, $id_grupo_equipo)
    // {
    //     $delete = DB::table('inti_grupo_equipo')->where('id_grupo_equipo', '=', $id_grupo_equipo)->delete();
 
    //     if ($delete) {
    //         $response = [
    //             'success' => true,
    //             'message' => 'Eliminado satisfactoriamente',
    //             'data' => $delete
    //         ];
            
    //     } else {
    //         $response = [
    //             'success' => false,
    //             'message' => 'No se pudo eliminar',
    //             'data' => $delete
    //         ];
    //     }
    //     return $response;
    // }
    public static function saveAsistenciaBoda($request, $fecha_reg)
    {
        $nombre = $request->nombre;
        $celular = $request->celular;

        // $count = DB::table('boda_asistencias')->where('celular', '=', $celular)->count();
        // if ($count == 0) {
        $id_asistencia =  Helpers::correlativo('boda_asistencias', 'id_asistencia');
        $numero = $id_asistencia < 10 ? ('0'.$id_asistencia) : $id_asistencia;
        $codigo = 'R&C'.$numero;
        $savegp = DB::table('boda_asistencias')->insert([
            'id_asistencia' => $id_asistencia,
            'nombre' => $nombre,
            'celular' => $celular,
            'codigo' => $codigo,
            'created_at' => $fecha_reg,
        ]);
        if ($savegp) {
            $response = [
                'success' => true,
                'message' => 'Ingresado satisfactoriamente',
                'data' => $codigo
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No se pudo registrar por completo',
                'data' => $codigo
            ];
        }
        // }  else {
        //     $response = [
        //         'success' => false,
        //         'message' => 'El celular ya esta registrado',
        //         'data' => $celular
        //     ];
        // }
        return $response;
    }
    public static function showCodeInvitation($request, $codigo)
    {
        // $codigo = $request->codigo;

        $data = DB::table('boda_asistencias')->where('codigo', '=', $codigo)->select('nombre', 'celular', 'codigo')->first();
        
        return $data;
    }
}
