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
            $table->string('size', 20)->after('category_id')->nullable()->comment('Size value for the brand size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brand_sizes', function (Blueprint $table) {
            $table->dropColumn('size_id');
        });
    }
};
