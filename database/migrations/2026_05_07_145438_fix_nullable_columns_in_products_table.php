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
        Schema::table('products', function (Blueprint $table) {
            $table->string('color')->nullable()->default(null)->change();
            $table->text('description')->nullable()->change();
            $table->string('main_image')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('color')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
            $table->string('main_image')->nullable(false)->change();
        });
    }
};
