<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualanBarang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $primaryKey = 'id';

    public function penjualanBarang()
    {
        return $this->belongsTo(PenjualanBarang::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
