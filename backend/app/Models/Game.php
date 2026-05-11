<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games';

    protected $fillable=['name','description','image'];

    public function users(){
        return $this->belongsToMany(User::class,'user_game');
    }

    public function tournament(){
        return $this->hasOne(tournament::class);
    }
}
