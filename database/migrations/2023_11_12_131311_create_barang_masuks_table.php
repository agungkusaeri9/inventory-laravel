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
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('kode')->unique();
            $table->foreignId('supplier_id')->constrained('supplier');
            $table->text('keterangan')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });
        Schema::create('barang_masuk_detail', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('barang_masuk_id')->constrained('barang_masuk')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('barang_id')->constrained('barang');
            $table->integer('jumlah');
            $table->integer('harga');
            $table->integer('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk_detail');
        Schema::dropIfExists('barang_masuk');
    }
};
