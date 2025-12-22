<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = 'tb_barang_masuk';

    protected $primaryKey = 'id_barang_masuk';

    protected $fillable = ['kode_barang',	'id_supplier',	'tanggal_masuk', 'jumlah_masuk',	'harga_beli',	'keterangan'];

    /**
     * Relasi ke tb_barang
     * tb_barang_masuk.kode_barang -> tb_barang.kode_barang
     */
    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'kode_barang', 'kode_barang');
    }

    /**
     * Relasi ke tb_supplier
     * tb_barang_masuk.id_supplier -> tb_supplier.id_supplier
     */
    public function supplier()
    {
        return $this->belongsTo(SupplierModel::class, 'id_supplier', 'id_supplier');
    }
}
