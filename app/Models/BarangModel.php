<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    protected $table = 'tb_barang';

    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'kode_barang', 'nama_barang', 'id_kategori', 'stok', 'harga',
    ];

    public function kategori()
    {
        // satu barang hanya punya 1 kategori
        return $this->belongsTo(KategoriModel::class, 'id_kategori', 'id_kategori');
    }

    public function BarangMasukById(){
        return $this->hasMany(BarangMasuk::class, 'id_barang','id_barang');
    }
}
