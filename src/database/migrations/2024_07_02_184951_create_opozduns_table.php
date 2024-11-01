<?php

use App\Models\OpozdunType;
use App\Models\User;
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
        Schema::create('opozduns', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete()
            ;
            $table->foreignIdFor(OpozdunType::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete()
            ;
            $table->json('answer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opozduns');
    }
};
