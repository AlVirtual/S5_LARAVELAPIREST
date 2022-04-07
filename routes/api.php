<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ShotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
Use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function(){

    Route::get('logout', [AuthController::class,'logout']);
    Route::get('user', [AuthController::class,'userInfo']);

    Route::post('players', [PlayerController::class, 'store'])->name('players.store');      // crea un jugador
    Route::put('players/{player}', [PlayerController::class, 'update'])->name('players.update');   // modifica el nom del jugador
    Route::post('players/{player}/games', [ShotController::class, 'store'])->name('players.store');  // un jugador específic realitza una tirada dels daus.
    Route::delete('players/{player}/games', [ShotController::class, 'destroy'])->name('players.destroy');  // elimina les tirades del jugador
    Route::get('players/{player}/games', [ShotController::class, 'show'])->name('players.show');  // retorna el llistat de jugades per un jugador.

    Route::get('players', [PlayerController::class, 'index'])->middleware(AdminMiddleware::class)->name('players.index'); // retorna el llistat de tots els jugadors del sistema amb el seu percentatge mig d’èxits 
    Route::get('players/ranking', [PlayerController::class, 'rank'])->middleware(AdminMiddleware::class)->name('players.rank');  // És a dir, el percentatge mig d’èxits.
    Route::get('players/ranking/loser', [PlayerController::class, 'loser'])->middleware(AdminMiddleware::class)->name('players.rankloser');  // retorna el jugador amb pitjor percentatge d’èxit
    Route::get('players/ranking/winner', [PlayerController::class, 'winner'])->middleware(AdminMiddleware::class)->name('players.rankwinner'); // retorna el jugador amb pitjor percentatge d’èxit.
});


