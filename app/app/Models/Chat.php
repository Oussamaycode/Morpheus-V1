<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    /** @use HasFactory<\Database\Factories\ChatFactory> */
    use HasFactory;

    protected $fillable=['name','owner_id'];

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function users(){
        return $this->belongsToMany(User::class,'chatParticipants'); 
    }

    public function owner(){
        return $this->belongsTo(User::class);
    }


}
