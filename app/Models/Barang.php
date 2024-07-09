<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected $primaryKey = 'id';
    public $incrementing = false;

    public function DetailPembelianBarang()
    {
        return $this->belongsTo(DetailPembelianBarang::class, 'id');
    }
}
