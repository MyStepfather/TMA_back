<?php

use App\Models\Category;
use App\Models\Presentation;
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
        Schema::create('category_presentation', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete()
            ;
            $table->foreignIdFor(Presentation::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete()
            ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_presentation');
    }
};
