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
       Schema::create('tb_barang_keluar', function (Blueprint $table) {
            $table->id('id_barang_keluar');
            $table->unsignedBigInteger('id_barang');

            $table->unsignedBigInteger('id_supplier');

            $table->dateTime('tanggal_keluar');
            $table->integer('jumlah_keluar');
            $table->decimal('harga_beli', 12, 2)->nullable();
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_supplier')
                ->references('id_supplier')
                ->on('tb_supplier')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('id_barang')
                ->references('id_barang')
                ->on('tb_barang')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_barang_keluar');
    }
};
