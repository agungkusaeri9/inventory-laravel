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
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('kode')->unique();
            $table->text('keterangan')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('barang_keluar_detail', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('barang_keluar_id')->constrained('barang_keluar')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('barang_id')->constrained('barang');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluar_detail');
        Schema::dropIfExists('barang_keluar');
    }
};
