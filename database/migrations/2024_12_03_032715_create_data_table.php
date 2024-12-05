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
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk')
                ->comment('nomor kk');
            $table->string('nik')
                ->comment('nomor induk kependudukan');
            $table->string('nama')
                ->comment('nama');
            $table->string('tempat_lahir')
                ->comment('tempat lahir');
            $table->string('tanggal_lahir')
                ->comment('tanggal lahir');
            $table->string('jenis_kelamin')
                ->comment('jenis kelamin');
            $table->string('agama')
                ->comment('agama');
            $table->string('kabupaten_asal')
                ->comment('asal kabupaten');
            $table->foreignId('kecamatan_asal_id')
                ->comment('kecamatan asal')
                ->constrained('kecamatans')
                ->onDelete('cascade');
            $table->foreignId('desa_asal_id')
                ->comment('desa asal')
                ->constrained('desas')
                ->onDelete('cascade');
            $table->string('alamat_asal')
                ->comment('asal alamat');
            $table->string('kabupaten_tujuan')
                ->comment('tujuan kabupaten');
            $table->foreignId('kecamatan_tujuan_id')
                ->comment('kecamatan tujuan')
                ->constrained('kecamatans')
                ->onDelete('cascade');
            $table->foreignId('desa_tujuan_id')
                ->comment('desa tujuan')
                ->constrained('desas')
                ->onDelete('cascade');
            $table->string('alamat_tujuan')
                ->comment('tujuan alamat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};
