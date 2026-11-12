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
        Schema::table('brand_sizes', function (Blueprint $table) {
            //
            $table->enum('size_of', ['A', 'K'])->default('A')->comment('Sizes for adults / kids')->after('product_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brand_sizes', function (Blueprint $table) {
            //
        });
    }
};
