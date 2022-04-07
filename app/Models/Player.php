<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;
    protected $fillable = ['name','winshots','loseshots','totalshots','percent','user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function shots()
    {
        return $this->hasMany('App\Models\Shot');
    }

    public function resetStats(Player $player)
    {
        $player->winshots = '0';
        $player->loseshots = '0';
        $player->totalshots = '0';
        $player->percent = '0';

        $player->save();
        
    }

    public function increStats(Player $playerup)
    {
        $playerup->increment('winshots');
        $playerup->increment('totalshots');
        $percent = ($playerup->winshots*100/$playerup->totalshots);
        $playerup->percent = $percent;

        $playerup->save();
        
    }

    public function decreStats(Player $playerup)
    {
        $playerup->increment('loseshots');
        $playerup->increment('totalshots');
        $percent = ($playerup->winshots*100/$playerup->totalshots);
        $playerup->percent = $percent;

        $playerup->save();
        
    }

}