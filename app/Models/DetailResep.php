<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailResep extends Model
{
    use HasFactory;
    protected $table = 'detail_resep';

    protected $fillable = [
        'id_bahan_baku',
        'id_resep',
        'jumlah',
    ];

    public function BahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan_baku', 'id_bahan_baku');
    }

    public function Resep()
    {
        return $this->belongsTo(Resep::class, 'id_resep', 'id_resep');
    }
}
