<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('hero')->default(false)->after('destaque');
            $table->unsignedSmallInteger('hero_order')->nullable()->after('hero');
            $table->index(['hero', 'hero_order']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['hero', 'hero_order']);
            $table->dropColumn(['hero', 'hero_order']);
        });
    }
};
