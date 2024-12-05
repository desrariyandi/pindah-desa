<?php

use App\Models\Kecamatan;
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
        Schema::create('desas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Kecamatan::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete()
                ->nullable()
                ->comment('id table kecamatan');
            $table->string('name')
                ->comment('nama desa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desas');
    }
};
