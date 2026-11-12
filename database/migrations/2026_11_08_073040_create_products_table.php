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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('randomid',255)->unique();
            $table->string('slug',255)->unique();
            $table->string('sku',255);
            $table->date('manufacturing_date')->nullable();
            $table->foreignId('user_id')->comment('who created this')->constrained('users')->onDelete('cascade');
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('gender_id')->constrained('genders')->onDelete('cascade');          
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->enum('is_featured', [0, 1])->default(0)->comment('1->Featured');    
            $table->enum('status', [0,1,2])->default(0)->comment('0->active,1->inactive,2->comming soon');
            $table->enum('is_deleted', [0, 1])->default(0)->comment('1->deleted');
            $table->dateTime('launching_date')
                ->comment('If status is comming soon')
                ->nullable();
            $table->string('image')->comment('Default Image')->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
