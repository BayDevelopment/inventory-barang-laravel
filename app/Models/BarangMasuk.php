<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = 'tb_barang_masuk';

    protected $primaryKey = 'id_barang_masuk';

    protected $fillable = ['id_barang', 'id_supplier',    'tanggal_masuk', 'jumlah_masuk',    'harga_beli',    'keterangan'];

    /**
     * Relasi ke tb_supplier
     * tb_barang_masuk.id_supplier -> tb_supplier.id_supplier
     */
    public function supplierById()
    {
        return $this->belongsTo(SupplierModel::class, 'id_supplier', 'id_supplier');
    }

    public function barangById()
    {
        return $this->belongsTo(BarangModel::class, 'id_barang', 'id_barang');
    }

    // public function kategoriBarangMasukById()
    // {
    //     // satu barang hanya punya 1 kategori
    //     return $this->belongsTo(KategoriModel::class, 'id_kategori', 'id_kategori');
    // }
}
