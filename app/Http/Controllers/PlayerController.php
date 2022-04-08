<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\User;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;


class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = Player::all(['name', 'percent']);

        return response()->json(compact('players'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $player = new Player();
        $player->name = $request->name ?? 'Anonim';
        $player->winshots = '0';
        $player->loseshots = '0';
        $player->totalshots = '0';
        $player->percent = '0';
        $player->user_id = Auth::user()->id;

        $playeruser = Player::where('user_id', Auth::user()->id)->first();


        if (!$playeruser) {

            $player->save();
            return response()->json(compact('player'));
        } else {

            return response()->json(['message' => 'Ja tens un player assignat.El teu player es:', $playeruser]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, Player $player)
    {
        $player->name = $request->name;

        if ($player->user_id != Auth::user()->id) {

            $playeruser = Player::where('user_id', Auth::user()->id)->first();
            return response()->json(['message' => 'Aquest jugador no et pertany. El teu jugador es:', compact('playeruser')]);
        } else {

            $player->save();
            return response()->json(compact('player'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function rank()
    {

        $average = Player::avg('percent');

        //$rank = Player::select(['name','percent'])->where('totalshots','!=','0')->orderByDesc('percent')->get();

        return response()->json(compact('average'));
    }


    public function loser()
    {
        $loser = Player::select(['name', 'percent'])->where('totalshots', '!=', '0')->orderBy('percent', 'asc')->first();

        return response()->json(compact('loser'));
    }


    public function winner()
    {
        $winner = Player::select(['name', 'percent'])->where('totalshots', '!=', '0')->orderBy('percent', 'desc')->first();

        return response()->json(compact('winner'));
    }
}
