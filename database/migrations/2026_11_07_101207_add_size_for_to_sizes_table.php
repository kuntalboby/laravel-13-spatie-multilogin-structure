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
        Schema::table('sizes', function (Blueprint $table) {
            //
            $table->enum('size_for', ['T', 'B', 'S'])->default('T')
                ->comment('T=Topwear, B=Bottomwear, S=Shoes');
            $table->enum('target_age', ['A', 'K'])->default('A')
                ->comment('A=For Adult, K=For Kids');    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sizes', function (Blueprint $table) {
            //
        });
    }
};
