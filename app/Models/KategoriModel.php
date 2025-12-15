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
}
