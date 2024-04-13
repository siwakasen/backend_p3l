<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Karyawan extends Authenticatable
{
    use HasFactory, HasApiTokens;
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
