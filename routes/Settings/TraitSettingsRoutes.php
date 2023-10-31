<?php

namespace Inti\Routes\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Settings\IntipazController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

trait TraitSettingsRoutes
{
    public static function mapSettingsRoutes()
    {
        Route::group(['prefix' => 'settings/intipaz', 'namespace' => 'Settings'], function () {
            Route::get('equipements', [IntipazController::class, 'listEquipement']);
            Route::get('group-equipe', [IntipazController::class, 'listGroupEquipement']);
            Route::get('table-position', [IntipazController::class, 'listTablePosition']);
            Route::get('partities', [IntipazController::class, 'listPartities']);
            Route::post('partities', [IntipazController::class, 'savePartities']);
            Route::put('partities/{id_partido}', [IntipazController::class, 'updatePartities']);
            Route::delete('partities/{id_partido}', [IntipazController::class, 'deletePartities']);
            Route::get('equipo-partities', [IntipazController::class, 'getGroupEquipement']);
            Route::put('start-partities/{id_partido}', [IntipazController::class, 'startPartities']);
            Route::put('result-partities/{id_partido_detalle}', [IntipazController::class, 'updateResultadoPartities']);
            Route::put('finish-partities/{id_partido}', [IntipazController::class, 'finishPartities']);
            Route::post('groups', [IntipazController::class, 'saveGroup']);
            Route::post('group-equipe', [IntipazController::class, 'saveGroupsEquipe']);
        });
        Route::group(['prefix' => 'boda', 'namespace' => 'Settings'], function () {
            // Boda temporal
            Route::post('asistence', [IntipazController::class, 'saveAsistenciaBoda']);
            Route::get('asistence/{codigo}', [IntipazController::class, 'showCodeInvitation']);
        });
    }
}
