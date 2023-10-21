<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanBarang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected $primaryKey = 'id';
    public $incrementing = false;

    public function DetailPenjualanBarang()
    {
        return $this->hasMany(DetailPenjualanBarang::class);
    }

    public function pembeli(){
        return $this->belongsTo(Pembeli::class);
    }
}
