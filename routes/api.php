<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ShotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Route::post('players', [PlayerController::class, 'store'])->name('players.store');      // crea un jugador
Route::put('players/{player}', [PlayerController::class, 'update'])->name('players.update');   // modifica el nom del jugador
Route::post('players/{player}/games', [ShotController::class, 'store'])->name('players.store');  // un jugador específic realitza una tirada dels daus.
Route::delete('players/{player}/games', [ShotController::class, 'destroy'])->name('players.destroy');  // elimina les tirades del jugador

Route::get('players', [PlayerController::class, 'index'])->name('players.index');//revisar  // retorna el llistat de tots els jugadors del sistema amb el seu percentatge mig d’èxits 

Route::get('players/{player}/games', [ShotController::class, 'show'])->name('players.index');  // retorna el llistat de jugades per un jugador.
Route::get('players/ranking', [PlayerController::class, 'rank'])->name('players.rank');  // retorna el ranking mig de tots els jugadors del sistema. És a dir, el percentatge mig d’èxits.
Route::get('players/ranking/loser', [PlayerController::class, 'loser'])->name('players.rankloser');  // retorna el jugador amb pitjor percentatge d’èxit
Route::get('players/ranking/winner', [PlayerController::class, 'winner'])->name('players.rankwinner'); // retorna el jugador amb pitjor percentatge d’èxit.



