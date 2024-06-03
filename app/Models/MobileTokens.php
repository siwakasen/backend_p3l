<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileTokens extends Model
{
    use HasFactory;

    protected $table = 'mobile_tokens';

    public $timestamps = false;

    protected $fillable = [
        'token',
        'id_user',
    ];
}
