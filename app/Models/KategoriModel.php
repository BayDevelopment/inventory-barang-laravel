<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    protected $table = 'tb_kategori';

    protected $primaryKey = 'id_kategori';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = ['kategori', 'satuan'];

    public function barang()
    {
        return $this->hasMany(
            BarangModel::class,
            'id_kategori', // FK di tb_barang
            'id_kategori'  // PK di tb_kategori
        );
    }
    // public function barangMasuk()
    // {
    //     return $this->hasMany(
    //         BarangMasuk::class,
    //         'id_kategori', // FK di tb_barang
    //         'id_kategori'  // PK di tb_kategori
    //     );
    // }
}
