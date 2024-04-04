<?php

namespace App\Models;

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
        'stok_produk'
    ];

    public function Kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function Penitip()
    {
        return $this->belongsTo(Penitip::class, 'id_penitip', 'id_penitip');
    }

    public function Resep()
    {
        return $this->belongsTo(Resep::class, 'id_resep', 'id_resep');
    }
}
