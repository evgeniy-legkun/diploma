<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    const UNIT_KILOGRAMS = 1;
    const UNIT_LITERS = 2;

    protected $table = 'materials';
    protected $fillable = ['name', 'unit'];
    public $timestamps = false;
}
