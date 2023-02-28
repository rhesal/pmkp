<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master_unit extends Model
{
    use HasFactory;

    protected $table = 'master_unit';

    protected $fillable = [
        'unit',
        'status'
    ];
}
