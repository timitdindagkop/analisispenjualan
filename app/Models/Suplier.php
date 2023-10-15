<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected $primaryKey = 'id';
    public $incrementing = false;

    public function barang(){
        return $this->hasMany(Barang::class);
    }

    public function pembelian_barang(){
        return $this->hasMany(PembelianBarang::class);
    }
}
