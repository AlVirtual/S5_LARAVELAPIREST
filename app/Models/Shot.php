<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Shot extends Model
{
    use HasFactory;
    protected $fillable = ['dice1', 'dice2', 'result', 'total', 'player_id'];

    public function player()
    {
        return $this->belongsTo('App\Models\Player');
    }
}
