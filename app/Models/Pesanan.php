<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';

    protected $fillable = [
        'id_user',
        'no_nota',
        'metode_pemesanan',
        'metode_pengiriman',
        'bukti_pembayaran',
        'ongkir',
        'total_harga',
        'total_bayar',
        'status_transaksi',
        'tanggal_pesanan',
        'tanggal_diambil',
        'tanggal_pembayaran',
        'alamat_pengiriman',
        'tip',
        'poin_dipakai',
        'poin_didapat'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }
}
