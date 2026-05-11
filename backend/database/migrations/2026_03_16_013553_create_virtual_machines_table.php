<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('virtual_machines', function (Blueprint $table) {
            $table->id();
            $table->string('public_ip');
            $table->string('cpu');
            $table->string('gpu');
            $table->integer('storage');
            $table->string('vast_instance_id')->unique();
            $table->foreignId('user_id')->constrained()->unique(); 
            $table->foreignId('plan_id')->constrained();
            $table->string('status')->default('on');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtual_machines');
    }
};
