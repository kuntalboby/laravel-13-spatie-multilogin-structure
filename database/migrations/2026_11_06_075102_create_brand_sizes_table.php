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
        Schema::create('brand_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('randomid')->unique();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('size_id')->constrained('sizes')->onDelete('cascade');
            $table->enum('product_type', ['T', 'B', 'S'])->default('T')
                ->comment('T=Topwear, B=Bottomwear, S=Shoes');
            $table->enum('size_unit', ['in', 'cm'])->default('in')
                ->comment('in=inches, cm=centimeters');
            $table->string('size_chart')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_sizes');
    }
};
