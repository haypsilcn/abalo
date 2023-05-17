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
        Schema::create('shopping_cart_item', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedBigInteger("shopping_cart_id");
            $table->foreign("shopping_cart_id")
                ->references("id")->on("shopping_cart")
                ->onUpdate("cascade")->onDelete("cascade");
            $table->unsignedBigInteger("article_id");
            $table->foreign("article_id")
                ->references("id")->on("articles")
                ->onUpdate("cascade")->onDelete("cascade");
            $table->timestamp("create_date")->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_cart_item');
    }
};
