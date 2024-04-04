<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailHampers extends Model
{
    use HasFactory;
    protected $table = 'detail_hampers';

    protected $fillable = [
        'id_produk',
        'id_bahan_baku',
        'id_hampers'
    ];

    public function Produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function BahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan_baku', 'id_bahan_baku');
    }

    public function Hampers()
    {
        return $this->belongsTo(Hampers::class, 'id_hampers', 'id_hampers');
    }
}
