<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianBarang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected $primaryKey = 'id';
    public $incrementing = false;

    public function DetailPembelianBarang()
    {
        return $this->hasMany(DetailPembelianBarang::class, 'pembelianbarang_id', 'id');
    }
}
