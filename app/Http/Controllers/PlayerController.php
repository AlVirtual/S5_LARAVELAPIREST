<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
//use App\Http\Controllers\Auth;
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
        $players = Player::all(['name','percent']);
        
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
        $request->validate([
            'name' => 'required|string',
            'user_id' => 'unique:user_id',
        ]);
        
        $player = new Player();
        $player->name = $request->name;
        $player->winshots = $request->winshots;
        $player->loseshots = $request->loseshots;
        $player->totalshots = $request->totalshots;
        $player->percent = $request->percent;
        $player->user_id = Auth::user()->id;

        
        $player->save();
        return response()->json(compact('player'));

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

        $player->save();
        return response()->json(compact('player'));
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
        $rank = Player::select(['name','percent'])->where('totalshots','!=','0')->orderByDesc('percent')->get();
        
        //$players = Player::avg('percent');

        return response()->json(compact('rank'));
    }


    public function loser()
    {
        $loser = Player::select(['name','percent'])->where('totalshots','!=','0')->orderBy('percent','asc')->first();
        
        return response()->json(compact('loser'));
    }


    public function winner()
    {
        $winner = Player::select(['name','percent'])->where('totalshots','!=','0')->orderBy('percent','desc')->first();
        
        return response()->json(compact('winner'));
    }


}
