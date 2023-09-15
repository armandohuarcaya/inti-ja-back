<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class Helpers
{
    static public function getIPLocalClient(){ /// obtener la ip local del cliente.
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    public static function fnBuscar($dato)
    {
        $q = "translate(UPPER(" . $dato . "), 'áéíóúàèìòùãõâêîôôäëïöüçñÁÉÍÓÚÀÈÌÒÙÃÕÂÊÎÔÛÄËÏÖÜÇÑ','aeiouaeiouaoaeiooaeioucnAEIOUAEIOUAOAEIOOAEIOUCN')";
        return $q;
    }
    public static function msgError($e)
	{
		$mesageError = 'Error en: '.$e->getMessage().' | Linea: '.$e->getLine().' | Code: '.$e->getCode();
		return $mesageError;
	}
    public static  function correlativo($tabla, $columna = 'id', $pcolumna = array())
    {
        $q = DB::table($tabla);
        $idMax = $q->max($columna);
        $id = (int)$idMax + 1;
        return $id;
    }
}
