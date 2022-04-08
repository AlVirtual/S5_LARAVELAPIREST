<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shot;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;


class ShotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shots = Shot::all();
        return $shots;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Player $player)
    {

        //comprovar que el player pertany al user

        if ($player->user_id != Auth::user()->id) {

            $playeruser = Player::where('user_id', Auth::user()->id)->first();
            return response()->json(['message' => 'Aquest jugador no et pertany. El teu jugador es:', compact('playeruser')]);
        } else {

            //executem la partida amb jugador, daus i resultat
            $player = $player->id;
            $dice1 = rand(1, 6);
            $dice2 = rand(1, 6);

            $result = (($dice1 + $dice2) === 7) ? true : false;

            //guardem la partida
            $shot = new Shot();

            $shot->dice1 = $dice1;
            $shot->dice2 = $dice2;
            $shot->result = $result;
            $shot->total = ($dice1 + $dice2);
            $shot->player_id = $player;

            $shot->save();

            //actualitzem els estats del jugador
            $playerup = Player::find($player);
            if ($result == true) {

                $playerup->increStats($playerup);
            } else {

                $playerup->decreStats($playerup);
            }

            //retornem json

            return response()->json(compact('player', 'dice1', 'dice2', 'result'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {

        if ($player->user_id != Auth::user()->id) {

            $playeruser = Player::where('user_id', Auth::user()->id)->first();
            return response()->json(['message' => 'Aquest jugador no et pertany. El teu jugador es:', compact('playeruser')]);
        } else {
            $playershots = Shot::where('player_id', $player->id)->get();

            if (empty($playershots)) {

                return response()->json(['message' => 'No tens historial de jugades o aquest a sigut esborrat']);
            } else {

                return response()->json(compact('playershots'));
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shot $shot, Player $player)
    {
        //Comprovar si les jugades pertanyen al jugador
        if ($player->user_id != Auth::user()->id) {

            $playeruser = Player::where('user_id', Auth::user()->id)->first();
            return response()->json(['message' => 'Aquest jugador no et pertany. El teu jugador es:', compact('playeruser')]);
        } else {

            //Esborrem jugades del jugador
            $playershots = Shot::where("player_id", "=", "$player->id");

            $playershots->delete();

            //Actualitzem estats del jugador
            $player = Player::find($player->id);
            $player->resetStats($player);

            return response()->json(['message' => 'Partides esborrades correctament. El teu marcador s\'ha establert a 0']);
        }
    }
}
