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
        Schema::create('topping_movements', function (Blueprint $table) {
            $table->bigIncrements('tp_mv_id');
            $table->unsignedBigInteger('tp_tp_move_id');
            $table->enum('tp_mv_type', ['in', 'out']);
            $table->integer('tp_mv_qty');
            $table->timestamps();

            $table->foreign('tp_tp_move_id')->references('tp_id')->on('toppings')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topping_movements');
    }
};
