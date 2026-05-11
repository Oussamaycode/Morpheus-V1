<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    /** @use HasFactory<\Database\Factories\TournamentFactory> */
    use HasFactory;

    protected $fillable=['name','game_id','start_date','status'];

    public function game(){
        return this->belongsTo(Game::class);
    }

    public function users(){
        return $this->belongsToMany(User::class,'tournament_participants');
    }

}
