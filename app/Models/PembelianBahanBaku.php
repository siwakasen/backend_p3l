<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianBahanBaku extends Model
{
    use HasFactory;
    protected $table = 'pembelian_bahan_baku';
    protected $primaryKey = 'id_pembelian';

    protected $fillable = [
        'id_bahan_baku',
        'jumlah',
        'harga',
        'tanggal_pembelian',
    ];

    public function BahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan_baku', 'id_bahan_baku');
    }
}
