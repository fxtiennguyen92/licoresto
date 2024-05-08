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
            $table->uuid('id');
            $table->string('name', 200)->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->text('images')->nullable();
            $table->float('price')->default(0);
            $table->boolean('discount_flg')->default(false);
            $table->float('net_price')->default(0);
            $table->boolean('featured_flg')->default(false);
            $table->boolean('popular_flg')->default(false);
            $table->boolean('published_flg')->default(false);
            $table->boolean('active_flg')->default(false);
            $table->softDeletes();
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
