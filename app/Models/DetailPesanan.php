<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;
    protected $table = 'detail_pesanan';

    protected $fillable = [
        'id_produk',
        'id_hampers',
        'id_pesanan',
        'status_pesanan',
        'jumlah',
        'subtotal',
    ];

    public function Produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function Hampers()
    {
        return $this->belongsTo(Hampers::class, 'id_hampers', 'id_hampers');
    }

    public function Pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}
