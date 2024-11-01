<?php

use App\Models\Category;
use App\Models\Company;
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
        Schema::create('requisites', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->foreignIdFor(Company::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete()
            ;
            $table->date('date');
            $table->json('entities')->nullable();
            $table->text('path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisites');
    }
};
