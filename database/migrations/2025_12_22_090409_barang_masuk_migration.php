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
        Schema::create('tb_barang_masuk', function (Blueprint $table) {
            $table->id('id_barang_masuk');

            $table->string('kode_barang', 20);
            $table->unsignedBigInteger('id_supplier');

            $table->dateTime('tanggal_masuk');
            $table->integer('jumlah_masuk');
            $table->decimal('harga_beli', 12, 2)->nullable();
            $table->string('keterangan', 255)->nullable();

            $table->timestamps();

            // Foreign Key
            $table->foreign('kode_barang')
                ->references('kode_barang')
                ->on('tb_barang')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('id_supplier')
                ->references('id_supplier')
                ->on('tb_supplier')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_barang_masuk');
    }
};
