<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PencatatanBahanBaku extends Model
{
    use HasFactory;
    protected $table = 'pencatatan_bahan_bakus';

    protected $fillable = [
        'id_bahan_baku',
        'jumlah',
        'tanggal_pencatatan',
    ];

    public function BahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan_baku', 'id_bahan_baku');
    }
}
