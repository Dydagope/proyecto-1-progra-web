<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('producer');
            $table->text('description');
            $table->string('image')->nullable();

            $table->decimal('price', 10, 2);

            $table->enum('wine_type', [
                'Tinto',
                'Blanco',
                'Rosado',
            ]);

            $table->string('grape');

            $table->enum('country', [
                'Francia',
                'Chile',
                'Argentina',
                'España',
                'Italia',
                'Nueva Zelanda',
                'EE.UU.',
                'Australia',
            ]);

            $table->string('region');
            $table->string('appellation')->nullable();

            $table->unsignedSmallInteger('vintage_year')->nullable();

            $table->unsignedSmallInteger('volume_ml')->default(750);

            $table->decimal('alcohol_percentage', 4, 1)->default(12.0);

            $table->unsignedInteger('stock')->default(0);

            $table->enum('condition', [
                'Excelente',
                'Muy bueno',
                'Bueno',
            ])->default('Excelente');

            $table->string('rating_source')->nullable();

            $table->decimal('rating_score', 4, 1)->nullable();

            $table->boolean('is_featured')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};