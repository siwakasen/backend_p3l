<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';

    protected $fillable = [
        'id_role',
        'nama_karyawan',
        'email',
        'password',
        'tanggal_masuk',
        'bonus_gaji'
    ];

    public function Role()
    {
        return $this->belongsTo(Roles::class, 'id_role', 'id_role');
    }

    public function casts(): array
    {
        return [
            'password' => 'hashed'
        ];
    }
}
