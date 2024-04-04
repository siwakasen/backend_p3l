<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranLain extends Model
{
    use HasFactory;
    protected $table = 'pengeluran_lain';
    protected $primaryKey = 'id_pengeluaran';
    
    protected $fillable = [
        'nama_pengeluaran',
        'nominal_pengeluaran',
        'tanggal_pengeluaran'
    ];
}
