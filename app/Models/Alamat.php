<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;
    protected $table = 'alamat';
    protected $primaryKey = 'id_alamat';

    protected $fillable = ['id_user', 'alamat', 'kode_pos'];

    public function User()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
