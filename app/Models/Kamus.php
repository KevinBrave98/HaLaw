<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamus extends Model
{
    protected $table = 'kamuss';
    protected $primaryKey = 'istilah';
    public $incrementing = false;
    protected $fillable = [
        'istilah',
        'arti_istilah'
    ];
}
