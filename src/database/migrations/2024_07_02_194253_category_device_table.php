<?php

use App\Models\Category;
use App\Models\Company;
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
        Schema::create('category_device', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
            ;
            $table->foreignIdFor(Device::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
