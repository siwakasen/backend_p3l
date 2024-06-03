<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriSaldo extends Model
{
    use HasFactory;
    protected $table = 'histori_saldo';
    protected $primaryKey = 'id_histori_saldo';

    protected $fillable = [
        'id_user',
        'nominal_saldo',
        'keterangan_transaksi',
        'tanggal_pengajuan',
        'tanggal_konfirmasi'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
