<?php

namespace Inti\Routes\FiltersComun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FiltersComun\FiltersComunController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

trait TraitFiltersComunRoutes
{
    public static function mapFiltersComunRoutes()
    {
        Route::group(['prefix' => 'filters-comun', 'namespace' => 'FiltersComun'], function () {
            Route::get('diciplines', [FiltersComunController::class, 'getDicipline']);
            Route::get('categories', [FiltersComunController::class, 'getCategory']);
            Route::get('fases', [FiltersComunController::class, 'getFase']);
            Route::get('groups', [FiltersComunController::class, 'getGroup']);
            Route::get('periodos', [FiltersComunController::class, 'getPeriodo']);
            Route::get('equipes', [FiltersComunController::class, 'getEquipe']);
        });
    }
}