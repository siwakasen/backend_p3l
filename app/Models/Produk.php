<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_kategori',
        'id_penitip',
        'id_resep',
        'nama_produk',
        'foto_produk',
        'deskripsi_produk',
        'harga_produk',
        'stok_produk',
        'status_produk'
    ];

    public function Kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function Penitip()
    {
        return $this->belongsTo(Penitip::class, 'id_penitip', 'id_penitip');
    }

    public function DetailPesanan(){
        return $this->hasMany(DetailPesanan::class, 'id_produk', 'id_produk');
    }

    public function Resep()
    {
        return $this->belongsTo(Resep::class, 'id_resep', 'id_resep');
    }

    public function limitProduk()
    {
        return $this->hasMany(LimitProduk::class, 'id_produk', 'id_produk');
    }

    public function limitProdukHariIni()
    {
        return $this->hasOne(LimitProduk::class, 'id_produk')
            ->whereDate('tanggal', Carbon::now('Asia/Jakarta')->addDays(2)->format('Y-m-d'));
    }

    public function limitByDate($date)
    {
        return $this->hasOne(LimitProduk::class, 'id_produk')
            ->whereDate('tanggal', $date);
    }
}
