<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hampers extends Model
{
    use HasFactory;
    protected $table = 'hampers';
    protected $primaryKey = 'id_hampers';

    protected $fillable = [
        'nama_hampers',
        'foto_hampers',
        'deskripsi_hampers',
        'harga_hampers',
        'status_hampers'
    ];

    public function DetailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_hampers', 'id_hampers');
    }
}
