<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->string('color');
            $table->string('material')->default('Kulit Buaya Asli');
            $table->string('size')->nullable();
            $table->integer('stock')->default(10);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_promo')->default(false);
            $table->string('main_image');
            $table->string('whatsapp_number')->default('6285891056675');
            $table->string('tiktok_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
