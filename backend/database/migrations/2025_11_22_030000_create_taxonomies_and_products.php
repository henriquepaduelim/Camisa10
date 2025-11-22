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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('slug')->unique();
            $table->string('pais')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });

        Schema::create('leagues', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('slug')->unique();
            $table->string('pais')->nullable();
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('categories')->nullOnDelete();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('club_id')->nullable()->constrained('clubs')->nullOnDelete();
            $table->foreignId('league_id')->nullable()->constrained('leagues')->nullOnDelete();
            $table->text('descricao')->nullable();
            $table->decimal('preco', 10, 2);
            $table->decimal('preco_promocional', 10, 2)->nullable();
            $table->string('moeda', 5)->default('BRL');
            $table->boolean('ativo')->default(true);
            $table->boolean('destaque')->default(false);
            $table->boolean('mais_vendido')->default(false);
            $table->boolean('lancamento')->default(false);
            $table->string('sku')->nullable();
            $table->json('tags')->nullable();
            $table->unsignedInteger('estoque_total')->default(0);
            $table->timestamps();

            $table->index(['slug']);
            $table->index(['category_id', 'club_id', 'league_id']);
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('url');
            $table->string('alt')->nullable();
            $table->boolean('principal')->default(false);
            $table->unsignedInteger('ordem')->default(0);
            $table->timestamps();
        });

        Schema::create('product_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('tamanho', 10);
            $table->string('sku')->nullable();
            $table->decimal('preco', 10, 2)->nullable();
            $table->unsignedInteger('estoque')->default(0);
            $table->timestamps();
            $table->unique(['product_id', 'tamanho']);
        });

        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->enum('tipo', ['percentual', 'fixo']);
            $table->decimal('valor', 10, 2);
            $table->decimal('valor_minimo', 10, 2)->nullable();
            $table->unsignedInteger('limite_uso')->nullable();
            $table->unsignedInteger('usos')->default(0);
            $table->timestamp('expira_em')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('product_sizes');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('leagues');
        Schema::dropIfExists('clubs');
    }
};
