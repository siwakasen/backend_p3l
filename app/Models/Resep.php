<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;
    protected $table = 'resep';
    protected $primaryKey = 'id_resep';

    protected $fillable = ['nama_resep'];

    public function DetailResep()
    {
        return $this->hasMany(DetailResep::class, 'id_resep', 'id_resep');
    }
}
