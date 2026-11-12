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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('randomid')->unique();
            $table->foreignId('user_id')->comment('User who created the brand')->constrained('users')->onDelete('cascade');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('brand_logo')->nullable();
            $table->string('brand_code')->nullable();
            $table->string('description')->nullable(); 
            $table->enum('status', ['0', '1'])->default('0')->comment('0=active, 1=inactive');
            $table->enum('is_deleted', ['0', '1'])->default('0')->comment('0=active, 1=deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
