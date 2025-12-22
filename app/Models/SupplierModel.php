<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    protected $table = 'tb_supplier';

    protected $primaryKey = 'id_supplier';

    protected $fillable = ['nama_supplier', 'telp', 'alamat'];

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_supplier', 'id_supplier');
    }
}
