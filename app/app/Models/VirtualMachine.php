<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualMachine extends Model
{
    /** @use HasFactory<\Database\Factories\VirtualMachineFactory> */
    use HasFactory;

    protected $fillable = [
    'public_ip',
    'cpu',
    'gpu',
    'storage',
    'vast_instance_id',
    'user_id',
    'plan_id',
    ];

    public function user(){
        $this->belongsTo(User::class);
    }
}
