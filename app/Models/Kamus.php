<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kamus extends Model
{
    use HasFactory;

    protected $table = 'kamuss';
    protected $primaryKey = 'istilah';
    public $incrementing = false;
    protected $fillable = [
        'istilah',
        'arti_istilah'
    ];
}
