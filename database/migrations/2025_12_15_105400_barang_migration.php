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
         Schema::create('tb_barang', function (Blueprint $table){
            $table->id('id_barang');
            $table->string('kode_barang',50)->unique();
            $table->string('nama_barang',100);
            $table->foreignId('id_kategori')->constrained('tb_kategori')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('stok')->default(0);
            $table->decimal('harga',15,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_barang');
    }
};
