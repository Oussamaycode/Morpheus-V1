<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    /** @use HasFactory<\Database\Factories\PlanFactory> */
    use HasFactory;

    public function users(){
        
        return $this->belongsToMany(user::class,'subscriptions');
    }

    public function subscriptions(){
        return $this->hasMany(Subscription::class);
    }
}
