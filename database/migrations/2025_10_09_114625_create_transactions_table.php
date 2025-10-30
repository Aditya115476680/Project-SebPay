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
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('tr_id');
            $table->decimal('tr_total_amount', 10, 2);
            $table->decimal('tr_payment', 10, 2);
            $table->decimal('tr_change', 10, 2);
            $table->date('tr_date');
            $table->timestamps();


        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
