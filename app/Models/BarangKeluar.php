<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'tb_barang_keluar';
    protected $primaryKey = 'id_barang_keluar';

    protected $fillable = ['id_barang', 'id_supplier',    'tanggal_keluar', 'jumlah_keluar',    'harga_beli',    'keterangan'];

     public function supplierById()
    {
        return $this->belongsTo(SupplierModel::class, 'id_supplier', 'id_supplier');
    }

    public function barangById()
    {
        return $this->belongsTo(BarangModel::class, 'id_barang', 'id_barang');
    }
}
