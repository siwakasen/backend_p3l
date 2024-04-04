<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimitProduk extends Model
{
    use HasFactory;
    protected $table = 'limit_produk';
    protected $primaryKey = 'id_limit_produk';

    protected $fillable = [
        'id_produk',
        'limit',
        'tanggal',
    ];

    public function Produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
