<?php

use App\Models\Device;
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
        Schema::create('characteristics', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Device::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
            ;
            $table->json('info');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characteristics');
    }
};
